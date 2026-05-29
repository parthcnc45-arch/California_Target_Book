<script>
    $(document).ready(function() {
        $("#dateField").change(function() {
            if (!isValidDate(this.value)) {
                alert('Invalid date. Please enter a valid date in the format MM-DD-YYYY.');
                this.value=''
            }
        });

        function isValidDate(dateString) {
            var regex = /^\d{4}-\d{2}-\d{2}$/;
            return regex.test(dateString);
        }

        const form = $('#filter-form');
        form.on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            const formData = new FormData(this);
            formData.append('search', $('#searchQuery').val());
            formData.append('date', $('#dateField').val());
            formData.append('district', $('#districtField').val());
            formData.append('condidate', $('#condidateField').val());


            if (
                formData.get('search') ||
                formData.get('date') ||
                formData.get('district') ||
                formData.get('condidate')
            ) {
            $('#loader').removeClass('hidden');
            $('#articaleList').addClass('hidden');

            // Perform AJAX request
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(html) {
                  $('#articaleList').html('');
                  $('#articaleList').html(html);
                  $('#filter-form')[0].reset();
                  $("#districtField").addClass('d-none')
                  $('#loader').addClass('hidden');
                  $('#articaleList').removeClass('hidden');
                }
            });
        }
        });
        // Trigger form submission when user types
        var typingTimer;
        var doneTypingInterval = 1000; // 1 second (adjust as needed)

        // $('#searchQuery').on('input', function() {
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(function() {
        //         form.trigger('submit');
        //     }, doneTypingInterval);
        // });

        // $('#dateField').on('input', function() {
        //     clearTimeout(typingTimer);
        //     typingTimer = setTimeout(function() {
        //         form.trigger('submit');
        //     }, doneTypingInterval);
        // });


        // $('#districtField').on('change', function() {
        //     form.trigger('submit');
        // });
        // $('#condidateField').on('change', function() {
        //     form.trigger('submit');
        // });
        $("#applyFilter").click(function() {
            form.trigger('submit');
        });

        $("#filterByDate").click(function() {
            $('#dateField').toggleClass("d-none");
        });

        let dists = {};
        distMaping();
        function distMaping() {
            // Define a mapping of types to districts
            let AD_array = [];
            let SD_array = [];
            let CD_array = [];

            for (let index = 1; index < 81; index++) {
                let p= index < 10 ? 0 : '';
                    AD_array.push('AD' + p + index);
                if (index < 41) {
                        SD_array.push('SD' + p + index);
                }
                if (index < 53) {
                        CD_array.push('CD' + p + index);
                }
            }

            dists = {
                AD: AD_array,
                SD: SD_array,
                CD: CD_array,
            };
        }

        // Function to populate the City dropdown based on the selected Country
        function populateDists() {
            const selectedType = $("#distType").val();
            // console.log(selectedType)
            // console.log(dists)
            const districts = dists[selectedType];
            const distDropdown = $("#districtField");
            distDropdown.removeClass('d-none');
            distDropdown.empty();
            distDropdown.append($("<option>").text("Select District").val(""));

            if (districts) {
                districts.forEach(function (dist) {
                    distDropdown.append($("<option>").text(dist).val(dist));
                });
            }
        }


        $("#distType").on("change", function () {
            populateDists();
        });


        $(".favorite-toggle").click(function () {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var button = $(this);
            var articleId = button.closest(".favorite-main").data("article-id");
            var postId = button.closest(".favorite-main").data("post-id");
	    var userID = button.closest(".favorite-main").data("user-id");
	    console.log('Favorite Toggle clicked.', userID);
            $('#loaderSm', button.closest(".favorite-main")).removeClass('hidden'); // Show the loader for the current favorite-main
            $.ajax({
                type: "POST",
                url: "{{ route('book.hotsheet.favorite') }}",
                data: {
                    id: articleId ,
		    user_id: userID,
                    post_id: postId ,
                    _token: csrfToken
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                dataType: "json",
                success: function (data) {
                    if (data.favorite) {
                        button.html('<img width="25" src="{{ url('assets/imgs/fav.png') }}" alt="">');
                    } else {
                        button.html('<a type="button" class="text-decoration-none">Add To Fav?</a>');
                    }
                    $('#loaderSm', button.closest(".favorite-main")).addClass('hidden');
                },
                error: function (data) {
                    console.log(data);
                },
            });
        });


    });


  </script>
