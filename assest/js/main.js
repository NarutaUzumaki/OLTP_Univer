var parkCode = 3;
function getData() {
    // $.get("api/?action=getAuto&auto_code=4",(data)=>{
    //     console.log(data);
    // });
    $.get("/api/?action=getAuto&park_code=3", ({auto}) => {
        console.log(auto);
        updateTable(auto);
        updateHead(auto);
    });
}
function updateHead({parking}) {
    $('#park-name').html(parking.parkName);
    $('#park-places').html(parking.parkPlaces);
    $('#park-quantity').html(parking.parkPlacesTake);
}
function updateTable({rows}){
    console.log('I am working');
    $('#automobile > tbody tr:not(:first-child)').hide();
    var $rowNumb = 1;
    rows.forEach(row=>{
        var newRow=$('#automobile tbody tr#table-row-prototype').clone()
            .removeAttr('id').removeAttr('hidden').attr('auto_code', row.code);
        newRow.find('[scope=row]').html($rowNumb++);
        newRow.find('#car-0-number')
            .attr('id',`car-${row.code}-number`)
            .html(row.number);
        newRow.find('#car-0-code')
            .attr('id',`car-${row.code}-code`)
            .html(row.code);
        newRow.find('#car-0-brend')
            .attr('id',`car-${row.code}-brend`)
            .html(row.autoBrend);
        newRow.find('#car-0-owner')
            .attr('id',`car-${row.code}-owner`)
            .html(row.ownerName);
        newRow.find('#car-0-count')
            .attr('id',`car-${row.code}-count`)
            .html(row.pass_place_count);
        $('#automobile tbody').append(newRow);
    });

//    обработка кнопок
    $('.delete-row').click(
        (event) => {
            var rowCode = $(event.target).closest('[auto_code]').attr('auto_code');
            deleteRow(rowCode);
        }
    );

    $('.edit-row').click(
        (event) =>{
            var rowCode = $(event.target).closest('[auto_code]').attr('auto_code');
            // console.log(rowCode);
            editRow(rowCode);
        }
    );
}

function deleteRow(rowCode){
    $.ajax({
        type: "POST",
        url: "/api/?action=remAutoRow",
        data:{
            'auto_row_code':rowCode
        },
        success: (result) =>{
            if (result.deleted){
                $(`tr[auto_code=${rowCode}]`).remove();
                $(`tr[auto_code]`).each(function(i,elem){
                    $(elem).find(`[scope=row]`).html(i);
                });
            }
        }
    });
}

function editRow(rowCode){
    $.get("/api/?action=getAutoRow&auto_row_code=" + rowCode, ({autoRow}) =>{
        console.log(autoRow);
        $('#editModalLabel').html(autoRow.automobile.autoBrend);
        //my hidden data
        $('#rowCode').val(autoRow.automobile.code);
        $('#rowBrendCode').val(autoRow.automobile.brendCode);
        $('#rowOwnerCode').val(autoRow.automobile.ownerCode);
        //--------------
        $('#rowBrend').val(autoRow.automobile.autoBrend);
        $('#rowOwner').val(autoRow.automobile.ownerName);
        $('#rowPlaces').val(autoRow.automobile.pass_place_count);

        $('#editModal').modal('show');
    });
}

$().ready(()=>{
    getData();

    $('.add-row').click(()=> {
        $('#addModal').modal('show');
    });

    $('#addModalSave').click(()=>{
        $.ajax({
            type:"POST",
            url: "/api/?action=insAutoRow",
            data: {
                'auto_row_code': 0,//because for new row it is a autoincrement value in DataBase
                'auto_brend': $('#rowAddBrend').val(),
                'owner_name': $('#rowAddOwner').val(),
                'pass_places_count': $('#rowAddPlaces').val(),
                'number': $('#rowAddCarNumber').val(),
                'code_owner': 0,//because for new row it is a autoincrement value in DataBase
                'code_brend': 0,//because for new row it is a autoincrement value in DataBase
                'code_park': 3,
                'park_name': 'The Ajax'
            },
            success: (result)=>{
                console.log(result);
                if (result.inserted){
                    getData();
                }
                $('#addModal').modal('hide');
            }
        });
    });

    $('#editModalSave').click(() =>{
        $.ajax({
            type: "POST",
            url: "/api/?action=updAutoRow",
            data: {
                'auto_row_code': $('#rowCode').val(),
                'auto_brend': $('#rowBrend').val(),
                'owner_name': $('#rowOwner').val(),
                'pass_places_count': $('#rowPlaces').val(),
                'code_owner': $('#rowOwnerCode').val(),
                'code_brend': $('#rowBrendCode').val()
            },

            success: (result) => {
                if (result.updated){
                    $(`#car-${$('#rowCode').val()}-brend`).html($('#rowBrend').val());
                    $(`#car-${$('#rowCode').val()}-owner`).html($('#rowOwner').val());
                    $(`#car-${$('#rowCode').val()}-count`).html($('#rowPlaces').val());
                }

                $('#editModal').modal('hide');
            }
        });
    });
});