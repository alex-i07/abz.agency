$(document).ready(function () {
    $('#remove-employee').on('click', function(e) {

        var email = $('#email').val();

        axios.post('/about/delete', {'email':email})
            .then(function (response) {
                swal("Сотрудник был успешно удалён с базы данных!", {
                    icon: "success"
                });
            })
            .catch(function (error) {
                swal("Ошибка во время ajax-запроса!", {
                    icon: "error"
                });
            });

    });
});