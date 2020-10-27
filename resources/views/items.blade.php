<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{!! asset('css/app.css') !!}" rel="stylesheet">
</head>
<body>

    <h1 class="main-text"><span>Items Management Page</span></h1>

    <input class="add-item-txt" type="textbox" name="item_name" id="item_name" placeholder="Enter Item Name and click on Add">
    <button id="add-item" type="button" class="btn btn-default btn-sm">Add</button>
    <label class="selected-items">Selected items:</label>
    <div id="my-err" class="alert alert-danger aletr-dismissible my-err"></div>

    <!-- List Left Section Items -->
    <div class="subject-info-box-1">
        <select multiple="multiple" id='lstBox1' class="form-control">
            @foreach($leftItems as $item)
                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="subject-info-arrows text-center">
        <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
        <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
    </div>

    <!-- List Right Section Items -->
    <div class="subject-info-box-2">
        <select multiple="multiple" id='lstBox2' class="form-control">
            @foreach($rightItems as $item)
                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
            @endforeach
        </select>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script>
function strDes(a, b) {
    if (a.value>b.value) return 1;
    else if (a.value<b.value) return -1;
    else return 0;
}

(function () {
// ajax call for  Update Item position Right
$('#btnRight').click(function (e) {
    var selectedOpts = $('#lstBox1 option:selected');
    var selectedItemRight = $('#lstBox1').val();
    console.log(selectedItemRight);
    if (selectedOpts.length == 0) {
        alert("Nothing to move.");
        e.preventDefault();
    }

    $.ajax({
        url: "{{ route('toRight') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            id : selectedItemRight
        },
        success: function (response) {
            if(response.status == 'error'){
                $('.my-err').html("<p style='color:red'>"+ response.message+"</p>");
            }else{    
                $('#lstBox2').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            }
        },
    });

});

// ajax call for Update Item position Left
$('#btnLeft').click(function (e) {
    var selectedOpts = $('#lstBox2 option:selected');
    var selectedItemLeft = $('#lstBox2').val();
    console.log(selectedItemLeft);
    if (selectedOpts.length == 0) {
        alert("Nothing to move.");
        e.preventDefault();
    }
    $.ajax({
        url: "{{ route('toLeft') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            id : selectedItemLeft
        },
        success: function (response) {
            if(response.status == 'error'){
                $('.my-err').html("<p style='color:red'>"+ response.message+"</p>");
            }else{    
                $('#lstBox1').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            }
        },
    }); 
});
}(jQuery));

/* ajax call for Add  Item */
$('#add-item').click(function(){
    $('.my-err').html('');
    var name = $('#item_name').val();
    $.ajax({
        url: "{{ route('saveItem') }}",
        type: 'POST',
        data: {
            "_token": "{{ csrf_token() }}",
            name : name
        },
        success: function (response) {
            if(response.status == 'error'){
                $('.my-err').html("<p style='color:red'>"+ response.message+"</p>");
            }else{    
                $('#lstBox1').append("<option value="+ response.id +">"+response.item_name+"</option>");
                $('#item_name').val('');
            }
        },
        error: function (e) {
            $('.my-err').html("<p>"+ e.message+"</p>");
            setTimeout(function() {
                $('.my-err').fadeOut('fast');
            }, 5000);
        }
    });
});

// remove error text
$('#item_name').click(function(){
    $('.my-err').html('');
});
</script>
