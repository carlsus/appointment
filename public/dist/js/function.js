function clearForm($form_name){
    $($form_name)[0].reset();
    $($form_name +' #id').val('');
    $($form_name ).find('input,small').removeClass('is-invalid').text('');
    $($form_name ).find('select').removeClass('is-invalid').val('').attr('selected','selected').trigger('change');;
}
