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

        // swal({
        //     title: "Are you sure?",
        //     text: "Once deleted, you will not be able to recover this imaginary file!",
        //     icon: "warning",
        //     buttons: ['Отмена', 'Да'],
        //     dangerMode: true
        // })
        // .then(function (willDelete) {
        //     if (willDelete) {
        //         swal("Poof! Your imaginary file has been deleted!", {
        //             icon: "success"
        //         });
        //     }
        //     else {
        //         swal("Your imaginary file is safe!");
        //     }
        // });
    });
});