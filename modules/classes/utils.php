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
var_dump($matche->item->title);
			if (!$matche || $matche->item->title=='City not found' || !isset($matche->item->condition->text))
				return 'Cidade ou UF nao encontrado!';

			$weather = $matche->item->condition->text;
			$clima = $this->translateWeather2Clima($weather);
			$code = $matche->item->condition->code;
			$temp = $matche->item->condition->temp.'ºC';
			$forecast = json_encode($matche->item->forecast);
			$forecast = json_decode($forecast, true);

			$minima = $forecast[0]['low'].'ºC';
			$maxima = $forecast[0]['high'].'ºC';

			if (!$imagem_url = $this->getNewImage($weather))
				$imagem_url = "http://l.yimg.com/a/i/us/we/52/{$matche->item->condition->code}.gif";
			$imagem = "<img src='{$imagem_url}' title='{$weather}'/>";

			// $weather_class = format_result($matche);
			return array('clima'=>$clima, 'weather'=>$weather, 'code'=>$code, 'temperatura'=>$temp, 'minima'=>$minima, 'maxima'=>$maxima, 'imagem'=>$imagem, 'imagem_url'=>$imagem_url, 'cidade'=>$cidade_final);
		}
	}

	private function getNewImage($weather) {

		if ($weather=='Haze' || $weather=='Fog' || $weather=='Foggy')
			return STATIC_PATH.'clima/neblina.png';
		elseif (in_array($weather, array('Clear (Day)', 'Sunny', 'Fair (Day)', 'Hot')))
			return STATIC_PATH.'clima/dia-limpo.png';
		elseif (in_array($weather, array('Clear (Night)', 'Fair (Night)')))
			return STATIC_PATH.'clima/noite-limpa.png';
		elseif (in_array($weather, array('Cloudy', 'Mostly Cloudy (Day)', 'Partly Cloudy (Day)', 'Partly Cloudy', 'Mostly Cloudy')))
			return STATIC_PATH.'clima/nuvens-dia.png';
		elseif (in_array($weather, array('Mostly Cloudy (Night)', 'Partly Cloudy (Night)')))
			return STATIC_PATH.'clima/nuvens.png';
		elseif (in_array($weather, array('Drizzle', 'Freezing Rain', 'Scattered Showers', 'Light Snow Showers', 'Rain', 'Scattered Showers')))
			return STATIC_PATH.'clima/chuva-leve.png';
		elseif (in_array($weather, array('Tropical Storm', 'Severe Thunderstorms', 'Thunderstorms', 'Mixed Rain and Sleet', 'Showers', 'Isolated Thunderstorm', 'Scattered Thunderstorms', 'Isolated Thundershowers')))
			return STATIC_PATH.'clima/chuva-pesada.png';
		else
			return false;
	}

	public function translateWeather2Clima($weather)
	{
		$weather = strtolower($weather);
		switch($weather) {
			case 'tornado' : $clima = 'Tornado';
			break;
			case 'tropical storm' : $clima = 'Tempestade Tropical';
			break;
			case 'hurricane' : $clima = 'Furacão';
			break;
			case 'severe thunderstorms' : $clima = 'Tempestade Severa';
			break;
			case 'thunderstorms' : $clima = 'Trovoada';
			break;
			case 'mixed rain and snow' : $clima = 'Chuva e Neve';
			break;
			case 'mixed rain and sleet' : $clima = 'Chuva e Granizo';
			break;
			case 'mixed snow and sleet' : $clima = 'Neve e Granizo';
			break;
			case 'freezing drizzle' : $clima = 'Garoa Gelada';
			break;
			case 'drizzle' : $clima = 'Garoa';
			break;
			case 'freezing rain' : $clima = 'Chuva Gelada';
			break;
			case 'showers' : $clima = 'Chuva Pesada';
			break;
			case 'snow flurries' : $clima = 'Flocos de Neve';
			break;
			case 'light snow showers' : $clima = 'Light Snow Showers';
			break;
			case 'blowing snow' : $clima = 'Blowing Snow';
			break;
			case 'snow' : $clima = 'Neve';
			break;
			case 'hail' : $clima = 'Granizo';
			break;
			case 'sleet' : $clima = 'Chuva com Neve';
			break;
			case 'dust' : $clima = 'Poeira';
			break;
			case 'foggy' : $clima = 'Nebuloso';
			break;
			case 'fog' :
			case 'haze' : $clima = 'Neblina';
			break;
			case 'smoky' : $clima = 'Enfumaçado';
			break;
			case 'bluestery' : $clima = 'Bluestery';
			break;
			case 'windy' : $clima = 'Vento';
			break;
			case 'cold' : $clima = 'Frio';
			break;
			case 'cloudy' : $clima = 'Nublado';
			break;
			case 'mostly cloudy (night)' : $clima = 'Nublado (noite)';
			break;
			case 'mostly cloudy (day)' : $clima = 'Nublado (dia)';
			break;
			case 'partly cloudy (night)' : $clima = 'Parcialmente Nublado (noite)';
			break;
			case 'partly cloudy (day)' : $clima = 'Parcialmente Nublado (dia)';
			break;
			case 'clear (night)' : $clima = 'Limpo (noite)';
			break;
			case 'sunny' : $clima = 'Ensolarado';
			break;
			case 'fair (night)' : $clima = 'Fair (night)';
			break;
			case 'fair (day)' : $clima = 'Fair (day)';
			break;
			case 'mixed rain and hail' : $clima = 'Chuva e Granizo';
			break;
			case 'hot' : $clima = 'Quente';
			break;
			case 'isolated thunderstorm' : $clima = 'Tempestade Isolada';
			break;
			case 'scattered thunderstorms' : $clima = 'Tempestade Esparsa';
			break;
			case 'scattered showers' : $clima = 'Chuva Esparsa';
			break;
			case 'heavy snow' : $clima = 'Neve Pesada';
			break;
			case 'partly cloudy' : $clima = 'Parcialmente Nublado';
			break;
			case 'thundershowers' : $clima = 'Trovoadas';
			break;
			case 'snow showers' : $clima = 'Nevasca';
			break;
			case 'isolated thundershowers' : $clima = 'Trovoadas Isoladas';
			break;
			default: $clima =$weather;
		}
		return $clima;
	}

}