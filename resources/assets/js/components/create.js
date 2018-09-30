console.log('window.chiefsPerLevel', window.chiefsPerLevel, typeof window.chiefsPerLevel);

$(document).ready(function () {
    var selectLevels = document.getElementById("hierarchy");

    var selectChiefs = document.getElementById("chiefs");

    var chiefsPerLevelObject = JSON.parse(window.chiefsPerLevel);

    console.log(chiefsPerLevelObject);

    for(index in chiefsPerLevelObject) {

        console.log(index);
        selectLevels.options[selectLevels.options.length] = new Option(index, index);

    }

    chiefsPerLevelObject[1].forEach(function(item){
        selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
    });


    
    $('#hierarchy').on('change', function (e) {
        console.log(e.target);

        $('#chiefs').empty();

        chiefsPerLevelObject[selectLevels.selectedOptions[0].value].forEach(function(item){
            selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
        });
    });
});