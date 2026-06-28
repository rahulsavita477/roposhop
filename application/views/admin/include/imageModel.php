<div class="modal fade" id="enlargeImageModal" tabindex="-1" aria-labelledby="enlargeImageModal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
                <button class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Image Preview</h4>
            </div>
            
			<div class="modal-body">
				<img src="" class="enlargeImageModalSource">
			</div>

            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php include dirname(__FILE__).'/../../js_form_validation.php'; ?>

<script>
//remove image
function removeImage(image_no='')
{
    $('.file'+image_no).empty();
    $('#preview'+image_no).hide();
    $('#fileUploadDiv'+image_no).show();
    
    document.getElementById("file"+image_no).value = null;
}

function removeStaticImage(index) {
    
    // Hide preview
    document.getElementById('preview' + index).style.display = 'none';

    // Show upload again
    document.getElementById('fileUploadDiv' + index).style.display = 'inline-block';

    // Remove hidden input element itself
    const hiddenInputs = document.querySelectorAll('input[name="remove_img[]"]');
    if (hiddenInputs && hiddenInputs[index-1]) {
        hiddenInputs[index-1].remove();
    }
}

$(function() {
    $('img').on('click', function() {
		$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
		$('#enlargeImageModal').modal('show');
	});

	// Multiple images preview in browser
    var imagesPreview = function(input, placeToInsertImagePreview, image_no='', isFile='') {
    	if (input.files) 
        {
            var filesAmount = input.files.length;

            for (i = 0; i < filesAmount; i++) 
            {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var isValid = fileValidation(input.files[0]['name'], isFile);
                    var allowedFileTypes = 'JPG and PNG are allowed.';
                    if (isFile)
                        allowedFileTypes = 'PDF, '+allowedFileTypes;

                    if (!isValid)
                    {
                        alert(allowedFileTypes);
                        removeImage(image_no);
                        return;
                    }

                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    $('#preview'+image_no).show();
                    $('#fileUploadDiv'+image_no).hide();
                    // $('<button type="button" class="btn btn-danger" onclick="removeImage('+image_no+');">Remove</button>').appendTo(placeToInsertImagePreview);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
	};

    $('#file1').on('change', function() {
    	$('.file1').empty();
        imagesPreview(this, 'div.file1', 1);
    });

    $('#file2').on('change', function() {
    	$('.file2').empty();
        imagesPreview(this, 'div.file2', 2);
    });

    $('#file3').on('change', function() {
    	$('.file3').empty();
        imagesPreview(this, 'div.file3', 3);
    });

    $('#file4').on('change', function() {
    	$('.file4').empty();
        imagesPreview(this, 'div.file4', 4);
    });

    $('#file5').on('change', function() {
    	$('.file5').empty();
        imagesPreview(this, 'div.file5', 5);
    });

    $('#file6').on('change', function() {
    	$('.file6').empty();
        imagesPreview(this, 'div.file6', 6);
    });

    $('#file7').on('change', function() {
        $('.file7').empty();
        imagesPreview(this, 'div.file7', 7);
    });

    $('#file8').on('change', function() {
        $('.file8').empty();
        imagesPreview(this, 'div.file8', 8);
    });

    $('#file').on('change', function() {
        $('.file').empty();
        imagesPreview(this, 'div.file');
    });
});
</script>

<style type="text/css">
.file img, .file1 img, .file2 img, .file3 img, .file4 img, .file5 img, .file6 img, .file7 img, .file8 img{
	cursor: zoom-in;
}

.file img{
    margin: 2px;
}
</style>
