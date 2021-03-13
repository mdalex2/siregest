<?php
	include('class.kpaginate.php') ;

	/***********************/

	echo '<h1>One pagination ... :|</h1>' ;
	$kp1 = new kpaginate		;
	$kp1->setTotalItems(304)	;
	$kp1->setItemsPerPage(5)	;
	$limit = $kp1->getLimit()	;
	$kp1->paginate()			;
	echo '<pre>getLimit() method says: ' ; print_r($limit) ; echo '</pre>' ;

	/***********************/

	echo '<h1>Two paginations ... :)</h1>' ;
	$kp2 = new kpaginate			;
	$kp2->setCustomVar('cstvar')	;
	$kp2->setTotalItems(304)		;
	$kp2->setItemsPerPage(5)		;
	$limit = $kp2->getLimit()		;
	$kp2->paginate()				;
	echo '<pre>getLimit() method says: ' ; print_r($limit) ; echo '</pre>' ;

	/***********************/

	echo '<h1>Three paginations ... :D</h1>' ;
	$kp3 = new kpaginate		;
	$kp3->setTotalItems(304)	;
	$kp3->setItemsPerPage(5)	;
	$limit = $kp3->getLimit()	;
	$kp3->paginate()			;
	echo '<pre>getLimit() method says: ' ; print_r($limit) ; echo '</pre>' ;
?>
<style>
	body{
		font-family: arial ;
	}

	#kpaginate td{
		padding: 0 4px ;
		width: 20px ;
	}

	#kpaginate a{
		display: block ;
		font-family: arial ;
		font-size: 12px ;
		padding: 2px 0 ;
		text-align: center ;
		text-decoration: none ;
	}

	#kpaginate a.normal{
		background: #def ;
		color: #369 ;
	}

	#kpaginate a.selected{
		color: #fff ;
		display: block ;
		background: #f70 ;
	}

	#kpaginate a.back,
	#kpaginate a.next,
	#kpaginate a.backdis,
	#kpaginate a.nextdis{
		background: url('kpaginate-actions.png') no-repeat ;
		height: 14px ;
	}

	#kpaginate a.back{
		background-position: 0 0 ;
	}

	#kpaginate a.backdis{
		background-position: 0 -24px ;
	}

	#kpaginate a.next{
		background-position: -24px 0 ;
	}

	#kpaginate a.nextdis{
		background-position: -24px -24px ;
	}
</style>
