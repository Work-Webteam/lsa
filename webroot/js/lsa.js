//Add a default label to DataTables select dropdowns
/* jQuery-less version
let selectMenus = document.querySelectorAll('.dataTable thead select');
selectMenus.forEach(function(selectMenu)) {
    let option = document.createElement('option' );
    element.innerHTML = 'Filter';
    option.setAttribute('disabled', true);
    selectMenus.prepend(option);
}
 */

$('.dataTable').ready(function() {
    $('.dataTable thead select').append('<option disabled>Filter</option>');
});
