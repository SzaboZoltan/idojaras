<h1>Városok időjárási adatainak lekérdezése és megjelenítése</h1>
<div class="row">
    <h3>Városok listája</h3>
    <ol>
        {foreach $result.cityList as $item}
            <li>{$item.city}</li>
        {/foreach}
    </ol>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <form name="weather-form">
            <button id="getWeather" type="submit" class="btn btn-primary">Aktuális időjárás adatok lekérése a www.webservicex.net oldalról</button>
        </form>
    </div>
</div>
<div class="row">

</div>