$(document).ready(function () {
    let fieldCity = document.getElementById('get_city_cityName');
    console.log(fieldCity)
    console.log(fieldCity.value.length)

    // if(fieldCity.value.length > 3){
    //     var matchValue = $(this).value;
    //     console.log(matchValue)
    //     // $.ajax({
    //     //     url: '',
    //     //     type: 'POST',
    //     //     data: {value: matchValue},
    //     //     dataType: 'json',
    //     //     async: true,
    //     //
    //     //     success: function (data) {
    //     //         console.log(data)
    //     //     }
    //     // })
    // }

    fieldCity.addEventListener('input', function () {
        //console.log(fieldCity.value)
        if(fieldCity.value.length > 3){
            //console.log(fieldCity.value)
            $.ajax({
                    url: '/city-search',
                    type: 'POST',
                    data: {value: fieldCity.value},
                    dataType: 'json',
                    async: true,

                    success: function (data) {
                        console.log(data[0])
                        let ul = document.createElement('ul')
                        ul.setAttribute('id','cityList')
                        let cityList = data[0]

                        document.getElementById('renderList')
                        cityList.forEach(renderCitiesList)

                        function renderCitiesList(element, index, arr){
                            let li = document.createElement('li')
                            li.setAttribute('class', 'item')

                            ul.appendChild(li)

                            let t = document.createTextNode(element)

                            li.innerHTML = li.innerHTML + element
                        }
                    }
                })
        }
    })

    // fieldCity.addEventListener('change', function () {
    //     console.log(fieldCity.value)
    //     if(fieldCity.value.length > 3){
    //         console.log(fieldCity.value)
    //     }
    // })

    // $("#get_city_cityName").on('change', function (){
    //     //var matchValue = $(this).value;
    //     console.log($("#get_city_cityName").value.length);
    //
    //     if($("#get_city_cityName").value.length > 3){
    //         console.log($("#get_city_cityName").value)
    //     }
    //     // $.ajax({
    //     //     url: '',
    //     //     type: 'POST',
    //     //     data: {value: matchValue},
    //     //     dataType: 'json',
    //     //     async: true,
    //     //
    //     //     success: function (data) {
    //     //         console.log(data)
    //     //     }
    //     // })
    // })

    // $.ajax({
    //     url: '/user/account/ajax/checked/availabilities',
    //     type: 'POST',
    //     dataType: 'json',
    //     async: true,
    //
    //     success: function (datas) {
    //         // console.log(datas);
    //         let RangeDatas = Array.from(datas);
    //         if(datas !== null || datas !== undefined){
    //             if(datas !== ''){
    //                 RangeDatas = Object.values(datas);
    //                 // console.log(RangeDatas[0][0]);
    //                 RangeDatas[0].forEach((data, index) => {
    //                     // console.log(data);
    //                     for($i=0; $i<data.length; $i++){
    //                         if(data[$i] === 'lundi' || data[$i] === 'mardi' || data[$i] === 'mercredi' || data[$i] === 'jeudi' || data[$i] === 'vendredi' || data[$i] === 'samedi'){
    //                             let dayElement = 'availabilities_'+ data[$i] +'_0';
    //                             $('#'+ dayElement +'').prop("checked", true);
    //                             // console.log(data);
    //                         }
    //                         if(data[0] === 'lundi' || data[0] === 'mardi' || data[0] === 'mercredi' || data[0] === 'jeudi' || data[0] === 'vendredi' || data[0] === 'samedi'){
    //                             if(data[$i] === '09h-12h'){
    //                                 let hoursElement = ''+ data[0] +'hours';
    //                                 $('#availabilities_'+ hoursElement +'_0').prop("checked", true);
    //                             }else if(data[$i] === '12h-14h'){
    //                                 let hoursElement = ''+ data[0] +'hours';
    //                                 $('#availabilities_'+ hoursElement +'_1').prop("checked", true);
    //                             }else if(data[$i] === '14h-18h'){
    //                                 let hoursElement = ''+ data[0] +'hours';
    //                                 $('#availabilities_'+ hoursElement +'_2').prop("checked", true);
    //                             }else if(data[$i] === '18h-23h'){
    //                                 let hoursElement = ''+ data[0] +'hours';
    //                                 $('#availabilities_'+ hoursElement +'_3').prop("checked", true);
    //                             }
    //                         }
    //                     }
    //                 })
    //             }
    //         }
    //     },
    //     error: function (xhr, textStatus, errorThrown) {
    //         // alert('La requête ajax a échoué.');
    //     }
    // });
});
