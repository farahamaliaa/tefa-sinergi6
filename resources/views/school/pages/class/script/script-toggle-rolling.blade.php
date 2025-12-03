<script>
    @if (request()->has('search') || request()->has('name') || request()->has('page_left') || request()->has('page_right') || request()->has('search_left') || request()->has('search_right'))
        $('#minimize').removeClass('minimize')
        $('#minimize-button').addClass('minimize')
    @endif
    $('.toggle-rolling').click(function() {
        $('#minimize').removeClass('minimize')
        $('#minimize-button').addClass('minimize')
    });
    $('#back-button').click(function() {
        $('#minimize').addClass('minimize')
        $('#minimize-button').removeClass('minimize')
        
        const url = new URL(window.location.href);
        url.searchParams.delete('page_left');
        url.searchParams.delete('page_right');
        window.history.pushState({}, '', url);
    });


    $('#unrolling-student').submit(function(e) {
        e.preventDefault();

        let name = $('#input-search-left').val();

        $.ajax({
            type: "get",
            url: "{{ route('school.class-student.doesntHaveClassroom', request()->classroom->id) }}",
            data: {
                'name': name
            },
            dataType: "json",
            success: function(response) {
                console.log(response.data);
                $('#left-table tbody').empty();

                response.data.forEach((student, index) => {
                    $('#left-table tbody').append(`
                    <tr data-id="${student.id}">
                        <td>${index + 1}</td>
                        <td>${student.user.name}</td>
                        <td>${student.nisn}</td>
                        <td class="d-flex justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </td>
                    </tr>
                    `);
                });
            }
        });
    });
</script>
