 const showWeather=document.getElementById("showWeather");
 const inputCity=document.getElementById("inputCity");
 const labelCurrent=document.getElementById("currentWeather");
 const fiveDayslabel=document.getElementById("fiveDayslabel");    
 
 showWeather.addEventListener("click",getData);
function getData()
{
    var valueOfinput=inputCity.value;
    console.log(valueOfinput);
 
    var xml=new XMLHttpRequest();
    xml.open("GET", `https://api.openweathermap.org/data/2.5/weather?q=${valueOfinput}&appid=7ded80d91f2b280ec979100cc8bbba94`, true);
    xml.onload=function()
    {
        if(xml.status>=200&&xml.status<300)
        {
            var data=JSON.parse(xml.responseText);
            displayWeather(data);
        }
        else
        {
            console.error("Blad w api");
        }
        console.log("Odpowiedź na Aktualną Pogodę:", xml.responseText);
    };
    xml.onerror = function () {
        console.error('Wystąpił błąd połączenia.');
      };
      xml.send();

        // Pobranie aktualnej pogody
    fetch(`https://api.openweathermap.org/data/2.5/weather?q=${valueOfinput}&appid=7ded80d91f2b280ec979100cc8bbba94`)
    .then(response => response.json())
    .then(data => {
        displayWeather(data);
        // Pobranie prognozy 5-dniowej
        return fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${valueOfinput}&appid=7ded80d91f2b280ec979100cc8bbba94`);
    })
    .then(response => response.json())
    .then(data => {
        console.log("Odpowiedź na Prognozę:", data);
    
        displayForecast(data);
    })
    .catch(error => {
        console.error('Wystąpił błąd:', error);
    });

}

function displayWeather(data) {
    var weatherInfo = document.getElementById("weather-info");
    
  
    var temperature = data.main.temp;
    var temperatureCelsius = Math.round(temperature - 273.15);
    var pressure=data.main.pressure;
    var description = data.weather[0].description;
    var wind=data.wind.speed;
    var cloudiness=data.clouds.all;
    var iconPath = "http://openweathermap.org/img/wn/" + data.weather[0].icon + ".png";
  
    
    var weatherString=`
    Temperatura:${temperatureCelsius}C<br>
    Cisnienie:${pressure}hpa<br>
    Opis:${description}<br>
    Prędkość wiatru:${wind}m/s<br>
    Zachmurzenie:${cloudiness}%<br>
    <img src=${iconPath}>
    
    `
  
    
    weatherInfo.innerHTML = weatherString;
  }

  function displayForecast(data) {
    var forecastDates = document.getElementById("weatherFivedays");
    forecastDates.innerHTML = ""; 

    var forecasts = data.list;
    var uniqueDates = [];

    forecasts.forEach(forecast => {
        var timestamp = forecast.dt;
        var date = new Date(timestamp * 1000);
        var currentDate = new Date();
        var dateString = date.toLocaleDateString();
        
        
        if (date.toDateString() === currentDate.toDateString()) {
            return;
        }

        var temperatureKelvin = forecast.main.temp; // Temperature in Kelvin
        var pressure = forecast.main.pressure;
        var description = forecast.weather[0].description;
        var windSpeed = forecast.wind.speed;
        var cloudiness = forecast.clouds.all;
        var iconPath = "http://openweathermap.org/img/wn/" + forecast.weather[0].icon + ".png";
        var temperatureCelsius = Math.round(temperatureKelvin - 273.15);

        if (!uniqueDates.includes(dateString)) {
            uniqueDates.push(dateString);

            var containerDiv = document.createElement("div");
            containerDiv.id = "containerDiv";
            containerDiv.innerHTML = `Data:${dateString} <br>
            Temperatura:${temperatureCelsius}°C <br>
            Ciśnienie:${pressure}hPa<br>
            Opis:${description}<br>
            Prędkość wiatru:${windSpeed}m/s<br>
            Zachmurzenie:${cloudiness}%<br>
            <img src=${iconPath}>`;

            forecastDates.appendChild(containerDiv);
        }
    });
}