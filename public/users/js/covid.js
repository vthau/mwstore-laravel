$(document).ready(function () {
    fetch("https://corona.lmao.ninja/v2/countries/")
        .then((res) => res.json())
        .then((res) => {
            const covids = res;

            const countrys = covids.map(function (covid, key) {
                if (key == 216)
                    return `<option value="${key}" selected>${covid.country}</option>`;
                return `<option value="${key}">${covid.country}</option>`;
            });
            $(".countrys").html(countrys);

            function changeCovid(key = 216) {
                const country = covids[key];

                document.title = country.country;
                $(".img-country").attr("src", country.countryInfo.flag);
                $(".covid-day").text(
                    `${country.country} - ${moment(country.updated).format(
                        "DD/MM/YYYY"
                    )}`
                );

                $(".today-case").text(country.todayCases);
                $(".total-case").text(country.cases);
                $(".today-recovered").text(country.todayRecovered);
                $(".total-recovered").text(country.recovered);
                $(".today-deaths").text(country.todayDeaths);
                $(".total-deaths").text(country.deaths);
            }

            changeCovid();

            $(document).on("change", ".countrys", function () {
                const key = $(this).val();

                changeCovid(key);
            });
        });
});
