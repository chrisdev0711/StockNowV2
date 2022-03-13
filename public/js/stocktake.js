$(document).ready(function () {    
    $(document).on('change', '#type_filter', function() {        
        var type = $(this).val();
        let default_option = `<option value="">-- Select Sub Type --</option>`;
        $('#subType_filter').html(default_option);

        if(type == 'By Category')
        {
            var html = `<option value="All Categories">All Categories</option>`;

            for(let i = 0 ; i < categories.length; i++)
                html += `<option value="${categories[i].name}">${categories[i].name}</option>`;

            $('#subType_filter').html(html);
        }

        if(type == 'By Supplier')
        {
            var html = `<option value="All Suppliers">All Suppliers</option>`;

            for(let i = 0; i < suppliers.length; i++)
                html += `<option value="${suppliers[i].company}">${suppliers[i].company}</option>`
            
            $('#subType_filter').html(html);
        }   
    });

    $(document).on('change', '#area_filter', function() {
        var type = $(this).val();
        $('#areaSub_filter').html(null);
        if(type == 'By Area')
        {
            var html = '';
            for(let i = 0; i < areas.length; i++)
                html += `<option value="${areas[i].name}">${areas[i].name}</option>`;

            $('#areaSub_filter').html(html);
        }

    });
});