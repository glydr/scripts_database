$(document).ready(function() {
    
    $('form[name="edit_report"]').validate({
        
        rules: {
            source_path: {
                required: true,
                maxlength: 255
            },
            title: {
                required: true,
                maxlength: 50
            },
            'target[]': {
                required: true
            },
            'execution[]': {
                required: true
            },
            'ministry[]': {
                required: true
            },
            description: {
                required: true,
                maxlength: 255
            },
            version_description: {
                required: true,
                maxlength: 255
            }
        },
        errorPlacement: function(error, element) {
            var name = $(element).attr('name');
            if (name === 'ministry[]' || name === 'target[]' || name === 'execution[]') {
                error.appendTo($(element).parent().parent());
            } else {
                error.appendTo($(element).parent());
            }
        },
        messages: {
            source_path: 'You must enter the source path!',
            'target[]': 'You must select at least one target audience.',
            'execution[]': 'You must select at least one execution point.',
            'ministry[]': 'You must select at least one ministry.'
           // description: 'Please enter a description for the report.',
            //version_description: 'You must enter a description for this version!'
        }
        
        
    });
    
    
});