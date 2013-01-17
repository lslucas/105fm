<?php

	ignore_user_abort(true);
	set_time_limit(0);

	$cupom = new GeraCupons();
	// $return = $cupom->novoCupom(1, 2);

	$i=$n=0;
	do {

		$cupom->novoCupomBuffer(); //gera novo cupom
		$i++;
		$n++;

		if ($i==5000) {
			//benchmark
			echo "\n\n Levou {$cupom->benchmark} segundos ou ".round(($cupom->benchmark/60), 2)." minutos para gerar {$i}, {$n} cupons no total";
			echo "\n-----------------------------------------------------------------------------";
			echo "\n\n";
			$i=0;
			sleep(3); // little breath
		}

	} while($cupom->limiteMaximo()===false); //enquando não chegar ao limite segue repetindo

	//benchmark
	echo "\n\n Levou {$cupom->benchmark} segundos ou ".round(($cupom->benchmark/60) ,2)." minutos para gerar {$i}, {$n} cupons no total";
	echo "\nFIM!";
	echo "\n////////////////////////////////////////////////////////////////////////////////////////";
	echo "\n\n";