<?php      
    if(isset($_REQUEST['start_date'])){$start_date = $_REQUEST['start_date'];}
    if(isset($_REQUEST['end_date'])){$end_date = $_REQUEST['end_date'];}
    if(isset($_REQUEST['portfolio'])){$portfolio = $_REQUEST['portfolio'];}
    if(isset($_REQUEST['client_id'])){$client_id = $_REQUEST['client_id'];}
    
    $date = strtotime($end_date);
    $yesterday =  date('Y-m-d', strtotime("-1 weekdays", $date));
    
    $month_ytd_start = date("Y-m-d", mktime(0,0,0,1,1,date("Y", strtotime($end_date))));
     
    $id = Yii::app()->user->id;
    $user_data = Users::model()->findByPk($id);
    $user_data->default_portfolio_id = $portfolio;
    $user_data->default_start_date = $start_date;
    $user_data->default_end_date = $end_date;
    $user_data->save();
    
    $portfolios = Yii::app()->db->createCommand("select * from portfolios where id = '$portfolio'")->queryAll(true);
    $portfolio_currency = $portfolios[0]['currency'];
    
    function recursivePorts($a_port_id, $a_client_id)
    {
        $answer=[];
        if($a_port_id != 0 && $a_port_id != "")
        {
            $answer_sql = Yii::app()->db->createCommand("select id from portfolios where client_id='$a_client_id' and id not in($a_port_id,0,'') and parrent_portfolio=$a_port_id")->queryAll(true);
            foreach($answer_sql as $mp)
            {
                array_push($answer, $mp['id']);
                $mpm=recursivePorts($mp['id'], $a_client_id);
                foreach($mpm as $mpmm)
                {
                    array_push($answer,$mpmm);
                }
            }
        }
        return $answer;
    }
    $xx=recursivePorts($portfolio,$client_id);
    $all_p_ids = implode("','", array_unique($xx));
    //array_push($xx, $portfolio);
    
    //$testing=recursivePorts(54,$client_id);
    //$testing = implode("','", array_unique($testing));
    
?>

<div id="makepdf">
<h3><i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h3>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1 class="span1">Overview
    <em><?php echo $portfolios[0]['portfolio']; ?> </em>
    <small><?php echo "   (" . $portfolio_currency . ")"; ?> </small>
  </h1>

<?php
    /*
    // Josef: replaced with recursivePorts Apr2018
    //////////////////////////////////////////
    $p_ids = []; 
    $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio = $portfolio")->queryAll(true);
    
    while(count($all_portfolios)>0){
        $new_ids = [];
        foreach($all_portfolios as $ap){
            $p_ids[] = $ap['id'];
            $new_ids[] = $ap['id'];
        }
        $new_p_ids = implode("','", array_unique($new_ids));
        $all_portfolios = Yii::app()->db->createCommand("select * from portfolios where parrent_portfolio in ('$new_p_ids')")->queryAll(true);
    }
    $all_p_ids = implode("','", array_unique($p_ids));
    ///////////////////////////////////////////////////////////////////////////////////
    */
        
    /*
    JOSEF: removed currencies 19/2/2018
    $portfolio_composition_sql = "select p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                                 sum(if(pr.trade_date = '$end_date', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav,  
                                 sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav_yest,
                                 sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}, 0)) trade
                                 from ledger l
                                 inner join portfolios p on p.id = l.portfolio_id
                                 inner join currency_rates cr on cr.day = l.trade_date 
                                 inner join prices pr on pr.instrument_id = l.instrument_id  
                                 inner join instruments i on i.id = l.instrument_id
                                 inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency                              
                                 where l.trade_date<='$end_date' and l.portfolio_id = '$portfolio' and l.trade_type Not in ('2')
                                 and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday')
                                 group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
                                 */
                                 
    $portfolio_composition_sql = "select p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                                 sum(if(pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav,  
                                 sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                                 sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade
                                 from ledger l
                                 inner join portfolios p on p.id = l.portfolio_id
                                 inner join prices pr on pr.instrument_id = l.instrument_id  
                                 inner join instruments i on i.id = l.instrument_id                              
                                 where l.trade_date<='$end_date' and l.portfolio_id = '$portfolio' and l.trade_type Not in ('2')
                                 and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday')
                                 group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
                                 
  
    Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
    $portfolio_composition = Yii::app()->db->createCommand($portfolio_composition_sql)->queryAll(true);
 
    /*
    JOSEF: removed currencies 19/2/2018
    $sub_portfolios_sql = "select portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                    sum(if(pr.trade_date = '$end_date', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav, 
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}, 0)) trade
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join currency_rates cr on cr.day = l.trade_date 
                    inner join prices pr on pr.instrument_id = l.instrument_id
                    inner join instruments i on i.id = l.instrument_id
                    inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency                   
                    where p.parrent_portfolio = $portfolio and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal
                    Union 
                    select p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal, 
                    sum(if(pr.trade_date = '$end_date', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav,
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price*curs.cur_rate/cr.{$portfolio_currency}, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price*l.currency_rate/cr.{$portfolio_currency}, 0)) trade 
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join portfolios p2 on p2.id = p.parrent_portfolio
                    inner join currency_rates cr on cr.day = l.trade_date
                    inner join prices pr on pr.instrument_id = l.instrument_id  
                    inner join instruments i on i.id = l.instrument_id
                    inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency                   
                    where p.parrent_portfolio in ('$all_p_ids') and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal";
    */                
    
                    
    $sub_portfolios_sql = "select portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav, 
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join prices pr on pr.instrument_id = l.instrument_id
                    inner join instruments i on i.id = l.instrument_id
                    where p.id in ('$all_p_ids') and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal
                    Union 
                    select p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal, 
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav,
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade 
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join portfolios p2 on p2.id = p.id
                    inner join prices pr on pr.instrument_id = l.instrument_id  
                    inner join instruments i on i.id = l.instrument_id
                    where p.id in ('$all_p_ids') and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal";
                    
                    /*
    $sub_portfolios_sql = "select portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                    sum(if(pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav, 
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join prices pr on pr.instrument_id = l.instrument_id
                    inner join instruments i on i.id = l.instrument_id
                    where p.parrent_portfolio='$portfolio' and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal
                    Union 
                    select p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal, 
                    sum(if(pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav,
                    sum(if( l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                    sum(if( l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade 
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join portfolios p2 on p2.id = p.parrent_portfolio
                    inner join prices pr on pr.instrument_id = l.instrument_id  
                    inner join instruments i on i.id = l.instrument_id
                    where p.parrent_portfolio='$portfolio' and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p2.portfolio, p2.allocation_min, p2.allocation_max, p2.allocation_normal";
                    */
                        
    Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();                
    $sub_portfolios = Yii::app()->db->createCommand($sub_portfolios_sql)->queryAll(true);
    
    $index_value = 0;
    $yesterday_value1 = 0;
    $yesterday_value2 = 0;
    $trade = 0;

    $sub_port_data = ''; 
    $port_data_table = ''; 
    $level1 = [];

    foreach($portfolio_composition as $sp1){ 
        $value[$sp1['portfolio']] = 0; 
        $index_value = $index_value + $sp1['nav'];
        $yesterday_value1 = $yesterday_value1 + $sp1['nav_yest'];
        $trade = $trade + $sp1['trade'];
     }
             
    foreach($sub_portfolios as $sp1){ 
        $value[$sp1['portfolio']] = 0;
        $index_value = $index_value + $sp1['nav'];
        $yesterday_value2 = $yesterday_value2 + $sp1['nav_yest']; 
        $trade = $trade + $sp1['trade'];
     }
     
    $pnl =  $index_value - $yesterday_value1 - $yesterday_value2 - $trade;
    
    //echo "'" . $testing . "'<br>";
    //echo $all_p_ids."<br";
    //echo $portfolio_composition_sql."<br>";
    //echo $sub_portfolios_sql."<br>";
    //echo $yesterday_value1."<br>";
    //echo $yesterday_value2 ."<br>";
    //echo $trade;
   
    /*         
    foreach($portfolio_composition as $sp2){ 
                $division  = 0;
                if(!($index_value==0)){$division  = $sp2['nav']*100/$index_value;}
                
                /*
                JOSEF: removing currencies 19/2/2018
                $port_data_table .= '<tr>
            						<td>Uncategorized</td>
            						<td>'.number_format($sp2['nav']).'</td>
            						<td>'.number_format($division, 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal'], 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal']-$division, 1).'%</td>
            						<td>'.number_format($sp2['allocation_min']).'-'.number_format($sp2['allocation_max']).'%</td>
            					  </tr>'; 
                /*
                
                $port_data_table .= '<tr>
            						<td>'.$sp2['portfolio'].'</td>
            						<td>'.number_format($sp2['nav']).'</td>
            						<td>'.number_format($division, 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal'], 1).'%</td>
            						<td>'.number_format($sp2['allocation_normal']-$division, 1).'%</td>
            						<td>'.number_format($sp2['allocation_min']).'-'.number_format($sp2['allocation_max']).'%</td>
            					  </tr>'; 
        
        $level1[] = array('name' => 'Uncategorized', 'y' => $division);  
        //$level1[] = array('name' => 'Uncategorized', 'y' => $division);  JOSEF 19/2/2018                           
  }
  
  ////////////////////////
    foreach($sub_portfolios as $sp2){ 
        $division  = 0;
        if(!($index_value==0)){$division  = $sp2['nav']*100/$index_value;}
        $sub_port_data .= '<tr>
    						<td>'.$sp2['portfolio'].'</td>
    						<td>'.number_format($sp2['nav']).'</td>
    						<td>'.number_format($division, 1).'%</td>
    						<td>'.number_format($sp2['allocation_normal'], 1).'%</td>
    						<td>'.number_format($sp2['allocation_normal']-$division, 1).'%</td>
    						<td>'.number_format($sp2['allocation_min']).'-'.number_format($sp2['allocation_max']).'%</td>
    					  </tr>'; 
        $level1[] = array('name' => $sp2['portfolio'], 'y' => $division);                           
    }
    */
  
    
    // JOSEF MAY18 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $tag_port_data = '';
    
    // First get the portfolio composition
    $josef1 = Yii::app()->db->createCommand("SELECT id, portfolio, allocation_min, allocation_max, allocation_normal FROM portfolios WHERE parrent_portfolio=$portfolio")->queryAll(true);
    foreach($josef1 as $josef2)
    {
        $josefId= $josef2['id'];
        $josef3 = recursivePorts($josefId, $client_id);
        $josef4 = implode("','", array_unique($josef3));
        //$josef4 = $josef2['id'] . "'" . implode("','", array_unique($josef3));
        $josef5 = "select portfolio, p.allocation_min, p.allocation_max, p.allocation_normal, 
                    sum(if(l.trade_date < '$end_date' and pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav, 
                    sum(if(l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                    sum(if(l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade
                    from ledger l
                    inner join portfolios p on p.id = l.portfolio_id
                    inner join prices pr on pr.instrument_id = l.instrument_id
                    inner join instruments i on i.id = l.instrument_id
                    where (p.id = '$josefId' or p.id in ('$josef4')) and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                    and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                    group by p.portfolio, p.allocation_min, p.allocation_max, p.allocation_normal";
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();                
        $josef6 = Yii::app()->db->createCommand($josef5)->queryAll(true);
        
        $josef6b = 0;
        foreach($josef6 as $josef6a)
        {
            $josef6b = $josef6b + $josef6a['nav'];
            //$josef6c = 0;
            //if(!($index_value==0)){$josef6c=$josef6a['nav']*100/$index_value;}
            //$level1[] = array('name' => $josef6a['portfolio'], 'y' => $josef6c);
        }
        
        $josef7  = 0;
        if(!($index_value==0)){$josef7=$josef6b*100/$index_value;}
        $level1[] = array('name' => $josef2['portfolio'], 'y' => $josef7);
        
        $sub_port_data .= '<tr>
    						<td>'.$josef2['portfolio'].'</td>
    						<td>'.number_format($josef6b).'</td>
    						<td>'.number_format($josef7, 1).'%</td>
    						<td>'.number_format($josef2['allocation_normal'], 1).'%</td>
    						<td>'.number_format($josef2['allocation_normal']-$josef7, 1).'%</td>
    						<td>'.number_format($josef2['allocation_min']).'-'.number_format($josef2['allocation_max']).'%</td>
    					  </tr>';
        if($josef7<$josef2['allocation_min'] || $josef7>$josef2['allocation_max'])
        {
            $tag_port_data .= '<tr>
    						<td><span class="description-percentage text-red">'.$josef2['portfolio'].'</span></td>
    						<td><span class="description-percentage text-red">'.number_format($josef6b).'</span></td>
    						<td><span class="description-percentage text-red">'.number_format($josef7, 1).'%</span></td>
    						<td><span class="description-percentage text-red">'.number_format($josef2['allocation_min'], 1).'%</span></td>
    						<td><span class="description-percentage text-red">'.number_format($josef2['allocation_max'], 1).'%</span></td>
    					  </tr>';
        }
        else
        {
            $tag_port_data .= '<tr>
    						<td><span class="description-percentage text-green">'.$josef2['portfolio'].'</span></td>
    						<td><span class="description-percentage text-green">'.number_format($josef6b).'</span></td>
    						<td><span class="description-percentage text-green">'.number_format($josef7, 1).'%</span></td>
    						<td><span class="description-percentage text-green">'.number_format($josef2['allocation_min'], 1).'%</span></td>
    						<td><span class="description-percentage text-green">'.number_format($josef2['allocation_max'], 1).'%</span></td>
    					  </tr>';
        }
        
    }
    
    // Add instruments in the portfolio
    $josef5 = "select i.instrument, 0 as allocation_min, 0 as allocation_max, 0 as allocation_normal, 
                sum(if(l.trade_date < '$end_date' and pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav, 
                sum(if(l.trade_date < '$end_date' and pr.trade_date = '$yesterday', l.nominal*pr.price, 0)) nav_yest,
                sum(if(l.trade_date='$end_date' and pr.trade_date <> '$yesterday', l.nominal*l.price, 0)) trade
                from ledger l
                inner join portfolios p on p.id = l.portfolio_id
                inner join prices pr on pr.instrument_id = l.instrument_id
                inner join instruments i on i.id = l.instrument_id
                where p.id = '$portfolio' and (pr.trade_date = '$end_date' or pr.trade_date = '$yesterday' )
                and l.is_current = 1 and l.trade_status_id = 2 and l.client_id = '$client_id' and l.trade_type Not in ('2')
                group by i.id";
    Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();                
    $josef6 = Yii::app()->db->createCommand($josef5)->queryAll(true);
    
    foreach($josef6 as $josef66)
    {
        $josef7  = 0;
        if(!($index_value==0)){$josef7=$josef66['nav']*100/$index_value;}
        $level1[] = array('name' => $josef66['instrument'], 'y' => $josef7);
        
        $sub_port_data .= '<tr>
    						<td>'.$josef66['instrument'].'</td>
    						<td>'.number_format($josef66['nav']).'</td>
    						<td>'.number_format($josef7, 1).'%</td>
    						<td></td>
    						<td></td>
    						<td></td>
    					  </tr>';
    }
    
    // JOSEF MAY18 /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
        <div class="box-footer">
          <div class="row">
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-text">MARKET VALUE</span><p>
                <span class="description-percentage text-black"><b><?php echo number_format($index_value); ?></b></span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-text">O/N P/L</span><p>
              <?php
                  if($pnl >= 0){echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'></i> " . number_format($pnl) . "</span>";
                  }else{echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'></i> " . number_format($pnl) . "</span>";} 
                  
                ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                /* Josef Apr2018
                $sql_ret = "select pr.trade_date, 
                        if(pr.trade_date >= '$start_date' and pr.trade_date<='$end_date', pr.return, 1) `return`, 
                        if(pr.trade_date >= GREATEST(MAKEDATE(year(now()),1), '$start_date') and pr.trade_date<='$end_date', pr.return, 1) ytd  
                        from portfolio_returns pr where pr.portfolio_id = '$portfolio'";
                */
                $sql_ret = "select pr.trade_date, 
                        if(pr.trade_date >= '$start_date' and pr.trade_date<='$end_date', pr.return, 1) `return`, 
                        if(pr.trade_date >= '$month_ytd_start' and pr.trade_date<='$end_date', pr.return, 1) ytd  
                        from portfolio_returns pr where pr.portfolio_id = '$portfolio'";
                $results_ret = Yii::app()->db->createCommand($sql_ret)->queryAll(true);
                
                $product = 1;
                $all_time_return = 1;
                $year_to_date_return = 1;
                foreach($results_ret as $res){
                    $all_time_return = $all_time_return * $res['return'];
                    $year_to_date_return = $year_to_date_return * $res['ytd'];            
                }
              ?>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block border-right">
                <span class="description-text">RETURN All Time</span><p>
                <span class="description-percentage text-black"><?php echo number_format(($all_time_return - 1)*100, 2); ?>%</span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
            <div class="col-sm-3 col-xs-6">
              <div class="description-block">
                <span class="description-text">RETURN YTD</span><p>
                <span class="description-percentage text-black"><?php echo number_format(($year_to_date_return - 1)*100, 2); ?>%</span>
              </div><!-- /.description-block -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.box-footer -->
	  </div><!-- /.box -->
	</div><!-- /.col -->
  </div><!-- /.row -->
	  
  <div class="row">
    <div class="col-md-12">
      <div class="box box">
	  
        <div class="box-header with-border">
          <h3 class="box-title">Portfolio Composition</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
		
        <div class="box-body">
         <!-- <div class="row">-->
            <div class="col-md-8">
			
              <div class="chart">
			       <div class="scrollit">
				  <table id="example1" class="table table-bordered table-hover">
					<thead>
					  <tr>
						<th>Name</th>
						<th>Value (<?php echo $portfolio_currency; ?>)</th>
						<th>Allocation</th>
						<th>Normal</th>
						<th>Diff</th>
						<th>Min-Max</th>
					  </tr>
					</thead>
					<tbody>
					  <tr>
						<td><?php echo $portfolios[0]['portfolio']; ?></td>
						<td><?php echo number_format($index_value); ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					  </tr>
                      <?php echo $port_data_table . $sub_port_data; //$inst_data; ?>
					<tbody>
				  </table>
				</div>	  
              </div><!-- /.chart-responsive -->
			  
            </div><!-- /.col -->
			
            <div class="col-md-4">              

<div id="container2" ></div>
<script>

$(function () {
    $('#container2').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        credits: {enabled: false},
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{name: '', colorByPoint: true, data: <?php echo json_encode($level1); ?>}]
        })
    });


</script>
                    </div><!-- /.col -->
					
                  <!--</div> /.row -->
                </div><!-- ./box-body -->
				
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                
<!-------------------------->
		  
          <div class="row">
            <div class="col-md-12">
              <div class="box">
			  
                <div class="box-header with-border">
                  <h3 class="box-title">Portfolio Performance</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
				
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
					
                      <div class="table">        
<?php       
    //$month_ytd_start = date('Y-01-01');
    $month_ytd_start = date("Y-m-d", mktime(0,0,0,1,1,date("Y", strtotime($end_date))));
    $month3_start = date( "Y-m-d", strtotime( "-3 month", strtotime($end_date) ));
    $month6_start = date( "Y-m-d", strtotime( "-6 month", strtotime($end_date) ));
    $month9_start = date( "Y-m-d", strtotime( "-9 month", strtotime($end_date) ));
    $month1y_start = date( "Y-m-d", strtotime( "-1 years", strtotime($end_date) ));
    
    $months = [];
    $series = [];  
    $tbl_rows = '';
    foreach($portfolios as $port){
        $portfolio_id = $port['id'];
        
    $sql_returns = "select * from portfolio_returns where portfolio_id = '$portfolio_id' and trade_date >= LEAST('$start_date','$month1y_start')  and trade_date<='$end_date' order by trade_date";
    
    $portfolio_results = Yii::app()->db->createCommand($sql_returns)->queryAll(true);
    if($portfolio_results){
        
        $port_chart_value = 1;
        $bench_chart_value = 1;
        
        $return_ytd = 1;
        $return_3m = 1;
        $return_6m = 1;
        $return_9m = 1;
        $return_1y = 1;
        
        $return_ytd_bench = 1;
        $return_3m_bench = 1;
        $return_6m_bench = 1;
        $return_9m_bench = 1;
        $return_1y_bench = 1;
        $port_data = [];
        $bench_data = [];
        
        foreach($portfolio_results as $pr){   
                   
            if(strtotime($pr['trade_date'])>= strtotime($start_date)){
                $port_ret[] = $pr['return'];
                $bench_ret[] = $pr['benchmark_return'];
                
                $port_chart_value = $port_chart_value * $pr['return']; 
                $bench_chart_value = $bench_chart_value * $pr['benchmark_return'];
                $port_data[] = [$pr['trade_date'], floatval($port_chart_value)];
                $bench_data[] = [$pr['trade_date'], floatval($bench_chart_value)]; 
                $months[] = $pr['trade_date']; 
                }
           
            if(strtotime($pr['trade_date'])>= strtotime($month_ytd_start)){$return_ytd = $return_ytd * $pr['return']; $return_ytd_bench = $return_ytd_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month3_start)){$return_3m = $return_3m * $pr['return']; $return_3m_bench = $return_3m_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month6_start)){$return_6m = $return_6m * $pr['return']; $return_6m_bench = $return_6m_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month9_start)){$return_9m = $return_9m * $pr['return']; $return_9m_bench = $return_9m_bench * $pr['benchmark_return'];}
            if(strtotime($pr['trade_date'])>= strtotime($month1y_start)){$return_1y = $return_1y * $pr['return']; $return_1y_bench = $return_1y_bench * $pr['benchmark_return'];}   
        }
        
        $return_all_time = $port_chart_value;
        $return_all_time_bench = $bench_chart_value;
     
    $series[] = ['name'=> $port['portfolio'], 'data'=> $port_data];
    $series[] = ['name'=> $port['portfolio']."-benchmark", 'data'=> $bench_data]; 
  
    $allstats = Calculators::CalcAllStats1($port_ret, $bench_ret);
    $allstats_bench = Calculators::CalcAllStats_bench($bench_ret, $bench_ret);    
   
  $tbl_rows .=   
    '<tr>
        <td>'. $port['portfolio'].'</td>
        <td>'. number_format(($return_all_time-1)*100, 2).'%</td>
        <td>'. number_format(($return_ytd-1)*100, 2).'%</td>
        <td>'. number_format(($return_3m-1)*100, 2).'%</td>
        <td>'. number_format(($return_6m-1)*100, 2).'%</td>
        <td>'. number_format(($return_9m-1)*100, 2).'%</td>
        <td>'. number_format(($return_1y-1)*100, 2).'%</td>
        <td>'. number_format($allstats[0]*100, 2).'%</td>
        <td>'. number_format($allstats[1], 3).'</td>
    </tr>';
   
  $tbl_rows .=   
    '<tr>
        <td>'. $port['portfolio'].'-Benchmark</td>
        <td>'. number_format(($return_all_time_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_ytd_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_3m_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_6m_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_9m_bench-1)*100, 2).'%</td>
        <td>'. number_format(($return_1y_bench-1)*100, 2).'%</td>
        <td>'. number_format($allstats_bench[0]*100, 2).'%</td>
        <td>'. number_format($allstats_bench[1], 3).'</td>
    </tr>';

$months = array_unique($months);  
?>               
        <table id="tablePerformance" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>AllTime</th>
                    <th>YTD</th>
                    <th>3M</th>
                    <th>6M</th>
                    <th>9M</th>
                    <th>1Y</th>
                    <th>Vol</th>
                    <th>Sharpe</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tbl_rows; ?>
            <tbody>
        </table>
        <div id="container1"></div>
<?php
}else{ ?>       
       <img style="height: 350px; margin: 0 auto; float: left; padding-left: 30%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/nodata.png" class="headerimg"/>
<?php } 
        }?>       
                     
          </div><!-- /.chart-responsive -->
        </div><!-- /.col -->
		
      </div><!-- /.row -->
      <div class="row">
        <div class="col-md-12">
		  <!--<canvas id="areaChart" height="200"></canvas>-->

<script>

$(function () {
    $('#container1').highcharts({
        chart: {type: 'spline'},
        title: { text: '' },
        subtitle: {  text: '' },
        xAxis: {
            type: 'datetime',
            minTickInterval: 30,
            categories: <?php echo json_encode($months);?>,
            //dateTimeLabelFormats: { // don't display the dummy year
                //month: '%b \'%y', //'%e. %b', '%b \'%y'
               // year: '%b'
           // },
            title: { text: '' }
        },
        yAxis: {
            title: { text: '' },
            //min: 0.1,
            //max: 1.35
        },
        
        plotOptions: {
            spline: {
                lineWidth: 2,
                states: { hover: {lineWidth: 5}
                    },
                
                marker: { enabled: false }
            }
        },   
        
        colors: ['#104E89', '#952C28', '#00FF00', '#0000FF', '#D13CD9', '#D93C78', '#AD3CD9', '#3CD9A5', '#90D93C', '#CED93C', '#D9AA3C', '#D97E3C', '#D95E3C', '#000BD5'],
        credits: {enabled: false},
        series: <?php echo json_encode($series); ?>
    });
});
</script>          
        </div><!-- /.col -->
      </div><!-- /.row -->
		  
    </div><!-- ./box-body -->
		
  </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->

<div class="row">
<div class="col-md-6">
  <div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">Cash Management</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div><!-- /.box-header -->
	
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
		
          <div class="table">              
      <?php 
        $rows = '';            
        
        /*
        JOSEF: removed currencies 19/2/2018
        $cf_sql = "select l.trade_date cash_flow_date, i.instrument, l.price * l.nominal*cr.{$portfolio_currency}/curs.cur_rate cash_flow, tt.trade_type cash_flow_type 
                    from ledger l
                    inner join trade_types tt on tt.id = l.trade_type
                    inner join instruments i on i.id = l.instrument_id
                    inner join currency_rates cr on cr.day = l.trade_date
                    inner join cur_rates curs on curs.day = l.trade_date and curs.cur = i.currency
                    inner join portfolios port on port.id = l.portfolio_id
                    where l.trade_date>='$end_date' 
                    and l.is_current = 1 and l.trade_status_id = 2
                    and (port.id = $portfolio or port.parrent_portfolio = $portfolio )
                    and l.client_id ='$client_id'
                    and l.trade_type <>1
                    order by l.trade_date desc
                    limit 6";
        */
        
        /* Josef Apr2018
        $cf_sql = "select l.trade_date cash_flow_date, i.instrument, l.price * l.nominal cash_flow, tt.trade_type cash_flow_type 
                    from ledger l
                    inner join trade_types tt on tt.id = l.trade_type
                    inner join instruments i on i.id = l.instrument_id
                    inner join portfolios port on port.id = l.portfolio_id
                    where l.trade_date>='$end_date' 
                    and l.is_current = 1 and l.trade_status_id = 2
                    and (port.id = $portfolio or port.parrent_portfolio = $portfolio )
                    and l.client_id ='$client_id'
                    and l.trade_type <>1
                    order by l.trade_date desc
                    limit 6";
        */
        $cf_sql = "select l.trade_date cash_flow_date, i.instrument, l.price * l.nominal cash_flow, tt.trade_type cash_flow_type 
                    from ledger l
                    inner join trade_types tt on tt.id = l.trade_type
                    inner join instruments i on i.id = l.instrument_id
                    inner join portfolios port on port.id = l.portfolio_id
                    where l.trade_date>='$end_date' 
                    and l.is_current = 1 and l.trade_status_id = 2
                    and (port.id = $portfolio or port.id in ('$all_p_ids') or port.parrent_portfolio in ('$all_p_ids') )
                    and l.client_id ='$client_id'
                    and l.trade_type <>1
                    order by l.trade_date desc
                    limit 6";
                                               
        Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
        $cf_results = Yii::app()->db->createCommand($cf_sql)->queryAll(true);
        
        $rows = ''; 
        if($cf_results){
        foreach($cf_results as $cf){

              $rows .= 	  
				  "<tr>
					<td>" . $cf['cash_flow_date']. "</td>
					<td>". $cf['instrument']. "</td>
					<td>" .number_format($cf['cash_flow']). "</td>
				  </tr>";
        } ?>
          <table id="tableCashManagement" class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Date</th>
					<th>Instrument</th>
					<th>Amount</th>
				  </tr>
				</thead>
				<tbody>
                    <?php echo $rows; ?>
				<tbody>
			  </table>
		       <?php }else{ ?>
                    <img style="height: 100%; margin: 0 auto; padding-left: 25%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/nodata.png" class="headerimg"/>
           <?php } ?>
		  </div> <!-- /.table -->
        </div><!-- class="col-md-6"> -->
      </div><!-- class="row"> -->
    </div><!-- class="box-body"> -->
		  
  </div><!-- /.box -->
</div><!-- /.col -->
					
<div class="col-md-6">
  <div class="box box-info">

    <div class="box-header with-border">
      <h3 class="box-title">Winners/Losers</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div><!-- /.box-header -->
	
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
	    <?php
	    
	        /*
	        JOSEF: removed currencies 19/2/2018
            $win_los_query = "select i.instrument,
                            sum( if(p.trade_date = '$end_date', p.price * l.nominal*cr.{$portfolio_currency}/curs.cur_rate, 0)) nav_today,
                            sum( if(p.trade_date = DATE_ADD('$end_date', INTERVAL -1 DAY), p.price * l.nominal*cr.{$portfolio_currency}/curs.cur_rate, 0)) nav_yesterday
                            from prices p
                            inner join ledger l on l.instrument_id = p.instrument_id
                            inner join currency_rates cr on cr.day = p.trade_date
                            inner join instruments i on i.id = p.instrument_id
                            inner join cur_rates curs on curs.day = p.trade_date and curs.cur = i.currency
                            inner join portfolios port on port.id = l.portfolio_id
                            where l.trade_status_id = 2 and l.is_current = 1 and l.client_id = '$client_id' 
                            and (port.id = $portfolio or port.parrent_portfolio = $portfolio )
                            and p.trade_date in(DATE_ADD('$end_date', INTERVAL -1 DAY), '$end_date')
                            group by i.instrument order by i.instrument, nav_today desc";
            */            
            
            $win_los_query = "select i.instrument,
                            sum( if(p.trade_date = '$end_date', p.price * l.nominal, 0)) nav_today,
                            sum( if(p.trade_date = DATE_ADD('$end_date', INTERVAL -1 DAY), p.price * l.nominal, 0)) nav_yesterday
                            from prices p
                            inner join ledger l on l.instrument_id = p.instrument_id
                            inner join instruments i on i.id = p.instrument_id
                            inner join portfolios port on port.id = l.portfolio_id
                            where l.trade_status_id = 2 and l.is_current = 1 and l.client_id = '$client_id' 
                            and (port.id = $portfolio or port.parrent_portfolio = $portfolio )
                            and p.trade_date in(DATE_ADD('$end_date', INTERVAL -1 DAY), '$end_date')
                            group by i.instrument order by i.instrument, nav_today desc";
            
            
            $win_los_query_josef = "
                 select 
                 i.instrument,
                 sum(if(p.trade_date = '$end_date', p.price * l.nominal, 0)) nav_today,
                 sum(if(p.trade_date=DATE_ADD('$end_date',INTERVAL-1 DAY),p.price*l.nominal, 0)) nav_yesterday
                   from prices p
                 inner join ledger l on l.instrument_id = p.instrument_id
                 inner join instruments i on i.id = p.instrument_id
                 inner join portfolios port on port.id = l.portfolio_id
                 where l.trade_status_id = 2 and l.is_current = 1 and l.client_id = '$client_id'
                
                and (port.id IN (SELECT A.id FROM portfolios A WHERE A.client_id=$client_id AND (A.id=$portfolio OR A.parrent_portfolio=$portfolio)) OR port.parrent_portfolio IN (SELECT A.id FROM portfolios A WHERE A.client_id=$client_id AND (A.id=$portfolio OR A.parrent_portfolio=$portfolio)))
                
                 and p.trade_date in(DATE_ADD('$end_date', INTERVAL -1 DAY), '$end_date')
                 group by i.instrument order by i.instrument, nav_today desc";
                 
                 
            $win_los_query_josef = "
                select instrument, nav_today, nav_yesterday, nav_today-nav_yesterday retval, if(nav_yesterday=0,0,(nav_today/nav_yesterday-1)*100) retrel
                from
                (
                select 
                	i.instrument instrument, 
                	sum(if(p.trade_date = '$end_date', p.price * l.nominal, 0)) nav_today, 
                	sum(if(p.trade_date='$yesterday',p.price*l.nominal, 0)) nav_yesterday 
                from prices p 
                	inner join ledger l on l.instrument_id = p.instrument_id 
                	inner join instruments i on i.id = p.instrument_id 
                	inner join portfolios port on port.id = l.portfolio_id 
                where 
                	l.trade_status_id = 2 and 
                	l.is_current = 1 and 
                	l.client_id = '$client_id' and 
                	p.trade_date in('$yesterday', '$end_date') and 
                	
                	(port.id = '$portfolio' or port.id in ('$all_p_ids') or port.parrent_portfolio in ('$all_p_ids')) 
                        
                group by i.instrument 
                order by i.instrument, nav_today desc) x
                
                order by retrel desc";
                 
                 
                            
            Yii::app()->db->createCommand("SET SQL_BIG_SELECTS = 1")->execute();
            //$win_los = Yii::app()->db->createCommand($win_los_query)->queryAll(true);
            $win_los = Yii::app()->db->createCommand($win_los_query_josef)->queryAll(true);
               $wl_cnt = count($win_los);
               if($wl_cnt>0){
               $rows_wl = '';
               $wids = [];
               for($i = 0; $i<$wl_cnt; $i++){
                    if($i<3 || ($i>=$wl_cnt-3 && $i>3)){
                        $wids[] = $i;
                    }
               }   
               //echo $win_los_query_josef;
               foreach($wids as $ii){
                if($ii <3){ 
                    /*
                    $rows_wl .=
                              "<tr>
                        		<td><span class='description-percentage text-green'><i class='fa fa-caret-up'></i>" .$win_los[$ii]['instrument']."</span></td>
                        		<td><span class='description-percentage text-green'>" . number_format($win_los[$ii]['nav_today'])."</span></td>
                        		<td><span class='description-percentage text-green'>" . number_format($win_los[$ii]['nav_today'] - $win_los[$ii]['nav_yesterday']). "</span></td>
                                <td><span class='description-percentage text-green'>" . number_format(($win_los[$ii]['nav_yesterday'] == 0) ? 0 : $win_los[$ii]['nav_today']/$win_los[$ii]['nav_yesterday']-1, 2) . "</span></td>
                        	  </tr>";  
                        	  */
                    if($win_los[$ii]['retrel'] > 0)
                    {
                        $clr = "green";
                        $arrow = "up";
                    }    
                    else
                    {
                        $clr = "red";
                        $arrow = "down";
                    }
                    if($win_los[$ii]['retrel'] != 0)
                        $rows_wl .=
                              "<tr>
                        		<td><span class='description-percentage text-" . $clr . "'><i class='fa fa-caret-" . $arrow . "'></i>" .$win_los[$ii]['instrument']."</span></td>
                        		<td><span class='description-percentage text-" . $clr . "'>" . number_format($win_los[$ii]['nav_today'])."</span></td>
                        		<td><span class='description-percentage text-" . $clr . "'>" . number_format($win_los[$ii]['nav_today'] - $win_los[$ii]['nav_yesterday']). "</span></td>
                                <td><span class='description-percentage text-" . $clr . "'>" . number_format($win_los[$ii]['retrel'], 2) . " %</span></td>
                        	  </tr>";  
                }else{
                    /*
                    $rows_wl .=
                              "<tr>
                        		<td><span class='description-percentage text-red'><i class='fa fa-caret-down'></i>" . $win_los[$ii]['instrument']. "</span></td>
                        		<td><span class='description-percentage text-red'>" . number_format($win_los[$ii]['nav_today']) . "</span></td>
                        		<td><span class='description-percentage text-red'>" . number_format($win_los[$ii]['nav_today']-$win_los[$ii]['nav_yesterday']) . "</span></td>
                                <td><span class='description-percentage text-red'>" . number_format(($win_los[$ii]['nav_yesterday'] == 0) ? 0 : $win_los[$ii]['nav_today']/$win_los[$ii]['nav_yesterday']-1, 2) . "</span></td>
                        	  </tr>";   */
                    if($win_los[$ii]['retrel'] > 0)
                    {
                        $clr = "green";
                        $arrow = "up";
                    }    
                    else
                    {
                        $clr = "red";
                        $arrow = "down";
                    }
                    if($win_los[$ii]['retrel'] != 0)
                        $rows_wl .=
                              "<tr>
                        		<td><span class='description-percentage text-" . $clr . "'><i class='fa fa-caret-" . $arrow . "'></i>" . $win_los[$ii]['instrument']. "</span></td>
                        		<td><span class='description-percentage text-" . $clr . "'>" . number_format($win_los[$ii]['nav_today']) . "</span></td>
                        		<td><span class='description-percentage text-" . $clr . "'>" . number_format($win_los[$ii]['nav_today']-$win_los[$ii]['nav_yesterday']) . "</span></td>
                                <td><span class='description-percentage text-" . $clr . "'>" . number_format($win_los[$ii]['retrel'], 2) . " %</span></td>
                        	  </tr>";   
               } }        
        ?>
          <div class="table">
			  <table id="tableWinners" class="table table-bordered table-hover">
				<thead>
				  <tr>
					<th>Instrument</th>
					<th>NAV</th>
					<th>Change(abs)</th>
                    <th>Change(rel)</th>
				  </tr>
				</thead>
				<tbody>
                <?php echo $rows_wl; ?>
				<tbody>
			  </table>
              <?php }else{ ?>
                    <img style="height: 100%; margin: 0 auto; padding-left: 25%;" src="<?php echo Yii::app()->theme->baseUrl; ?>/img/nodata.png" class="headerimg"/>
           <?php } ?>
		  </div> <!-- /.table -->
		  
        </div><!-- class="col-md-6"> -->
      </div><!-- class="row"> -->
    </div><!-- class="box-body"> -->
	
  </div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->

<?php
    //$all_p_ids_tag = "'$portfolio','$all_p_ids'";
    $tag_tag = Yii::app()->db->createCommand("select tl.tag, tl.limit_min, tl.limit_max, tl.portfolio_id from tag_limit tl where tl.client_id=$client_id")->queryAll(true);
    $tag_inst = Yii::app()->db->createCommand("select i.instrument, ti.instrument_id, ti.limit_min, ti.limit_max, ti.client_id, ti.portfolio_id from tag_instrument ti left join instruments i on ti.instrument_id=i.id where ti.client_id=$client_id")->queryAll(true);
    $tag_cnt = count($tag_tag) + count($tag_inst);
    if($tag_cnt>0)
    {
        foreach($tag_tag as $tag_tag_item)
        {
            $tag_tag_val = Yii::app()->db->createCommand("select ti.instrument_id, ti.portfolio_id from tag_instrument ti where ti.client_id=$client_id and ti.tag like ('%" . $tag_tag_item['tag'] . "%')")->queryAll(true);
            $tag_tag_item_nav = 0;
            foreach($tag_tag_val as $tag_tag_val_item)
            {
                $all_p_ids_x = recursivePorts($tag_tag_val_item['portfolio_id'],$client_id);
                array_push($all_p_ids_x, $portfolio);
                $all_p_ids_x = implode("','", array_unique($all_p_ids_x));
                $tag_tag_sql = "select 
                                	i.instrument, 
                                	ti.limit_min, 
                                	ti.limit_max, 
                                	sum(if(pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav
                                from 
                                	ledger l 
                                	inner join portfolios p on p.id = l.portfolio_id 
                                	inner join prices pr on pr.instrument_id = l.instrument_id 
                                	inner join instruments i on i.id = l.instrument_id 
                                    inner join tag_instrument ti on i.id = ti.instrument_id
                                where 
                                	l.trade_date<='$end_date' and 
                                	l.portfolio_id in ('$all_p_ids_x') and 
                                	l.trade_type Not in ('2') and 
                                	l.is_current = 1 and 
                                	l.trade_status_id = 2 and 
                                    l.instrument_id = '" . $tag_tag_val_item['instrument_id'] . "' and 
                                	l.client_id = '$client_id' and 
                                	pr.trade_date = '$end_date' 
                                group by i.instrument, ti.limit_min, ti.limit_max";
                $tag_tag_val_item_res = Yii::app()->db->createCommand($tag_tag_sql)->queryAll(true);
                if(count($tag_tag_val_item_res)>0){
                    $tag_tag_item_nav += floatval($tag_tag_val_item_res[0]['nav']);
                }
            }
            $tag_tag_item_alloc=$tag_tag_item_nav*100/$index_value;
            if($tag_tag_item_alloc<$tag_tag_item['limit_min'] || $tag_tag_item_alloc>$tag_tag_item['limit_max'])
            {
                $tag_port_data .= '<tr>
        						<td><span class="description-percentage text-red">'.$tag_tag_item['tag'].'</span></td>
        						<td><span class="description-percentage text-red">'.number_format($tag_tag_item_nav).'</span></td>
        						<td><span class="description-percentage text-red">'.number_format($tag_tag_item_alloc, 1).'%</span></td>
        						<td><span class="description-percentage text-red">'.number_format($tag_tag_item['limit_min'], 1).'%</span></td>
        						<td><span class="description-percentage text-red">'.number_format($tag_tag_item['limit_max'], 1).'%</span></td>
        					  </tr>';
            }
            else{
                $tag_port_data .= '<tr>
        						<td><span class="description-percentage text-green">'.$tag_tag_item['tag'].'</span></td>
        						<td><span class="description-percentage text-green">'.number_format($tag_tag_item_nav).'</span></td>
        						<td><span class="description-percentage text-green">'.number_format($tag_tag_item_alloc, 1).'%</span></td>
        						<td><span class="description-percentage text-green">'.number_format($tag_tag_item['limit_min'], 1).'%</span></td>
        						<td><span class="description-percentage text-green">'.number_format($tag_tag_item['limit_max'], 1).'%</span></td>
        					  </tr>';
            }
        }
        foreach($tag_inst as $tag_inst_item)
        {
            $tag_inst_alloc = 0;
            $tag_inst_sql = "select 
                            	i.instrument, 
                            	ti.limit_min, 
                            	ti.limit_max, 
                            	sum(if(pr.trade_date = '$end_date', l.nominal*pr.price, 0)) nav
                            from 
                            	ledger l 
                            	inner join portfolios p on p.id = l.portfolio_id 
                            	inner join prices pr on pr.instrument_id = l.instrument_id 
                            	inner join instruments i on i.id = l.instrument_id 
                                inner join tag_instrument ti on i.id = ti.instrument_id
                            where 
                            	l.trade_date<='$end_date' and 
                            	(l.portfolio_id = '$portfolio' or l.portfolio_id in ('$all_p_ids')) and 
                            	l.trade_type Not in ('2') and 
                            	l.is_current = 1 and 
                            	l.trade_status_id = 2 and 
                                l.instrument_id = '" . $tag_inst_item['instrument_id'] . "' and 
                            	l.client_id = '$client_id' and 
                            	pr.trade_date = '$end_date' 
                            group by i.instrument, ti.limit_min, ti.limit_max";
            $tag_inst_res = Yii::app()->db->createCommand($tag_inst_sql)->queryAll(true);
            
            if(count($tag_inst_res)>0){
                $tag_inst_alloc=floatval($tag_inst_res[0]['nav'])*100/$index_value;
            
                if($tag_inst_alloc<$tag_inst_item['limit_min'] || $tag_inst_alloc>$tag_inst_item['limit_max'])
                {
                    $tag_port_data .= '<tr>
            						<td><span class="description-percentage text-red">'.$tag_inst_item['instrument'].'</span></td>
            						<td><span class="description-percentage text-red">'.number_format($tag_inst_res[0]['nav']).'</span></td>
            						<td><span class="description-percentage text-red">'.number_format($tag_inst_alloc, 1).'%</span></td>
            						<td><span class="description-percentage text-red">'.number_format($tag_tag_item['limit_min'], 1).'%</span></td>
            						<td><span class="description-percentage text-red">'.number_format($tag_tag_item['limit_max'], 1).'%</span></td>
            					  </tr>';
                }
                else
                {
                    $tag_port_data .= '<tr>
            						<td><span class="description-percentage text-green">'.$tag_inst_item['instrument'].'</span></td>
            						<td><span class="description-percentage text-green">'.number_format($tag_inst_res[0]['nav']).'</span></td>
            						<td><span class="description-percentage text-green">'.number_format($tag_inst_alloc, 1).'%</span></td>
            						<td><span class="description-percentage text-green">'.number_format($tag_tag_item['limit_min'], 1).'%</span></td>
            						<td><span class="description-percentage text-green">'.number_format($tag_tag_item['limit_max'], 1).'%</span></td>
            					  </tr>';
                }
            }
        }
        
        echo "<div class='row'><div class='col-md-12'>
<div class='box box-info'>
<div class='box-header with-border'><h3 class='box-title'>Limit Status</h3><div class='box-tools pull-right'>
<button class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button><button class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button></div>
</div>
<div class='box-body'>
<div class='row'>
<div class='col-md-12'>
<div class='table'>
<table id='tableLimits' class='table table-bordered table-hover'>
<thead><tr><th>Label</th><th>Value</th><th>Allocation</th><th>Limit Min</th>
<th>Limit Max</th></tr></thead><tbody>$tag_port_data<tbody></table></div></div></div></div></div></div></div>";

    }
?>

</section>		
</div><!-- /.makepdf -->
<script>

  $(document).ready(function (){
    
    var table = $('#example').DataTable( {
    
        renderer: "bootstrap",
        //dom: '<"clear">&lt;<"clear">Bfrtip<"clear">',
        //"Dom": '<"H"lfr>t<"F"ip>' ,
        //sDom: 'lfrtip',
        
        dom: 'lBfrtip',
        displayLength: 10,
        filter: true,
        paginate: true,
        sort:true,
        //bsort: true,
        //'bSortable' : true,
        info: false,
        //scrollX: '100%',
        //scrollCollapse: true,
        //paging: false,
        //"bPaginate": true,
        //"bSort": true,
        //"bFilter": false,
        bJQueryUI: false,
        bProcessing: false,
        sScrollX: "100%",
        sScrollXInner: "110%",
        bScrollCollapse: true,
        
        columnDefs: [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }
            ],

        select: true,
    
        buttons: [
            /*{ extend: "create", editor: editor },
            { extend: "edit", editor: editor },
            { extend: "remove", editor: editor },*/
            <?php //echo $access_buttons; ?>
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            { extend: 'colvis', collectionLayout: 'fixed two-column',},  
        ],    
    } ); 

        var table1 = $('#example1').DataTable( {
    
        renderer: "bootstrap",
        //dom: '<"clear">&lt;<"clear">Bfrtip<"clear">',
        //"Dom": '<"H"lfr>t<"F"ip>' ,
        //sDom: 'lfrtip',
        
        //dom: 'lBfrtip',
        //dom: 'lBfrtip',
        
        displayLength: 10,
        
        filter: false,
        paginate: false,
        
        //filter: true,
        //paginate: true,
        
        sort:false,
        //bsort: true,
        //'bSortable' : true,
        info: false,
        //scrollX: '100%',
        //scrollCollapse: true,
        //paging:         false,
        //"bPaginate": true,
        //"bSort": true,
        //"bFilter": false,
        bJQueryUI: false,
        bProcessing: false,
        sScrollX: "100%",
        sScrollXInner: "100%",
        //sScrollXInner: "110%",
        bScrollCollapse: true,
        
        select: true,

        buttons: [
            /*{ extend: "create", editor: editor },
            { extend: "edit",   editor: editor },
            { extend: "remove", editor: editor },*/
            <?php //echo $access_buttons; ?>
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 5 ]
                }
            },
            { extend: 'colvis', collectionLayout: 'fixed two-column',},
        ],         
    } );
    });
</script>