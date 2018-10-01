$(document).ready(function () {
    var selectLevels = document.getElementById("hierarchy");

    var selectChiefs = document.getElementById("chiefs");

    if (selectLevels !=null && selectChiefs !=null) {
        console.log(window.chiefsPerLevel, typeof window.chiefsPerLevel, selectLevels, typeof selectLevels, selectChiefs, typeof selectChiefs);

        var chiefsPerLevelObject = JSON.parse(window.chiefsPerLevel);

        //Let set hierarchy and chief selects

        for(index in chiefsPerLevelObject) {

            selectLevels.options[selectLevels.options.length] = new Option(index, index);

        }

        chiefsPerLevelObject[1].forEach(function(item){
            selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
        });



        $('#hierarchy').on('change', function (e) {

            $('#chiefs').empty();

            chiefsPerLevelObject[selectLevels.selectedOptions[0].value].forEach(function(item){
                selectChiefs.options[selectChiefs.options.length] = new Option(item.name, item.id);
            });
        });
    }



    // if (window.chiefsPerLevel !== 'underfined'){
    //
    // }

});