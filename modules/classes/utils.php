<?php
class Utils {

	public function climaByCityState($args)
	{
		global $yql;

		// if (!isset($args['cidade']) || empty($args['cidade']))
			// return 'Cidade inválido!';
		if (!isset($args['uf']) || empty($args['uf']))
			return false;

		else {

			$cidade = !empty($args['cidade']) ? trim($args['cidade']).', ' : null;
			$uf = trim($args['uf']);
			$cidade_final = !empty($cidade) ? $cidade.$uf : $uf;

			$query = "select * from weather.forecast where woeid in (select woeid from geo.places(1) where text=\"{$cidade}{$uf}\") and u='c'";
			$matche = $yql->query($query);
			$matche = isset($matche->query->results->channel) ? $matche->query->results->channel : false;

			if (!$matche || !isset($matche->item->condition->text))
				return 'Cidade ou UF nao encontrado!';

			$weather = $matche->item->condition->text;
			$clima = $this->translateWeather2Clima($weather);
			$code = $matche->item->condition->code;
			$temp = $matche->item->condition->temp.'ºC';
			$imagem_url = "http://l.yimg.com/a/i/us/we/52/{$matche->item->condition->code}.gif";
			$imagem = "<img src='{$imagem_url}' title='{$weather}'/>";

			// $weather_class = format_result($matche);
			return array('clima'=>$clima, 'weather'=>$weather, 'code'=>$code, 'temperatura'=>$temp, 'imagem'=>$imagem, 'imagem_url'=>$imagem_url, 'cidade'=>$cidade_final);
		}
	}

	public function translateWeather2Clima($weather)
	{
		$weather = strtolower($weather);
		switch($weather) {
			case 'tornado' : $clima = 'tornado';
			break;
			case 'tropical storm' : $clima = 'tempestade tropical';
			break;
			case 'hurricane' : $clima = 'furacão';
			break;
			case 'severe thunderstorms' : $clima = 'tempestade severa';
			break;
			case 'thunderstorms' : $clima = 'trovoada';
			break;
			case 'mixed rain and snow' : $clima = 'chuva e neve';
			break;
			case 'mixed rain and sleet' : $clima = 'chuva e granizo';
			break;
			case 'mixed snow and sleet' : $clima = 'neve e granizo';
			break;
			case 'freezing drizzle' : $clima = 'garoa gelada';
			break;
			case 'drizzle' : $clima = 'garoa';
			break;
			case 'freezing rain' : $clima = 'chuva gelada';
			break;
			case 'showers' : $clima = 'chuva pesada';
			break;
			case 'snow flurries' : $clima = 'flocos de neve';
			break;
			case 'light snow showers' : $clima = 'light snow showers';
			break;
			case 'blowing snow' : $clima = 'blowing snow';
			break;
			case 'snow' : $clima = 'neve';
			break;
			case 'hail' : $clima = 'granizo';
			break;
			case 'sleet' : $clima = 'chuva com neve';
			break;
			case 'dust' : $clima = 'poeira';
			break;
			case 'foggy' : $clima = 'nebuloso';
			break;
			case 'haze' : $clima = 'neblina';
			break;
			case 'smoky' : $clima = 'enfumaçado';
			break;
			case 'bluestery' : $clima = 'bluestery';
			break;
			case 'windy' : $clima = 'vento';
			break;
			case 'cold' : $clima = 'frio';
			break;
			case 'cloudy' : $clima = 'nublado';
			break;
			case 'mostly cloudy (night)' : $clima = 'nublado (noite)';
			break;
			case 'mostly cloudy (day)' : $clima = 'nublado (dia)';
			break;
			case 'partly cloudy (night)' : $clima = 'parcialmente nublado (noite)';
			break;
			case 'partly cloudy (day)' : $clima = 'parcialmente nublado (dia)';
			break;
			case 'clear (night)' : $clima = 'limpo (noite)';
			break;
			case 'sunny' : $clima = 'ensolarado';
			break;
			case 'fair (night)' : $clima = 'fair (night)';
			break;
			case 'fair (day)' : $clima = 'fair (day)';
			break;
			case 'mixed rain and hail' : $clima = 'chuva e granizo';
			break;
			case 'hot' : $clima = 'quente';
			break;
			case 'isolated thunderstorm' : $clima = 'tempestade isolada';
			break;
			case 'scattered thunderstorms' : $clima = 'tempestade esparsa';
			break;
			case 'scattered showers' : $clima = 'chuva esparsa';
			break;
			case 'heavy snow' : $clima = 'neve pesada';
			break;
			case 'partly cloudy' : $clima = 'parcialmente nublado';
			break;
			case 'thundershowers' : $clima = 'trovoadas';
			break;
			case 'snow showers' : $clima = 'nevasca';
			break;
			case 'isolated thundershowers' : $clima = 'trovoadas isoladas';
			break;
			default: $clima = 'não disponível';
		}
		return $clima;
	}

}