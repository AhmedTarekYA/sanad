<div class="modal-dialog modal-dialog-vertical modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header px-4">
            <h5 class="modal-title">My Notes <span class="badge bg-danger ms-2"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="bg-light px-4 py-3">
            <ul class="nav nav-pills nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active all-notes active" data-bs-toggle="tab" href="#Notetab-all"  data-url =""role="tab"
                        aria-selected="true">All Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#Notetab-Business" role="tab"
                        aria-selected="false">Business</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#Notetab-Social" role="tab">Social</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link note-tap" data-bs-toggle="tab" href="#Notetab-Create"
                        data-url=" " role="tab"><i class="fa fa-plus me-2"></i>New</a>
                </li>
            </ul>
        </div>
        <div class="modal-body px-4 custom_scroll">
            <div class="tab-content p-0">
                <div class="tab-pane fade active show" id="Notetab-all" role="tabpanel">

                </div>
                <div class="tab-pane fade" id="Notetab-Business" role="tabpanel">
                    <div class="card ribbon mb-2">
                        <div class="option-2 bg-warning position-absolute"></div>
                        <div class="card-body">
                            <span class="text-muted">10 December 2021</span>
                            <p class="lead">Meeting with Mr.Lee</p>
                            <span>Many desktop publishing packages and web page editors now use Lorem Ipsum as their
                                default model</span>
                        </div>
                        <div class="card-footer pt-0 border-0">
                            <a class="btn btn-sm btn-outline-secondary" href="#"><i
                                    class="fa fa-star favourite-note"></i></a>
                            <a class="btn btn-sm btn-outline-secondary" href="#"><i
                                    class="fa fa-trash favourite-note"></i></a>
                        </div>
                    </div>
                    <div class="card ribbon mb-2">
                        <div class="option-2 bg-danger position-absolute"></div>
                        <div class="card-body">
                            <span class="text-muted">01 December 2021</span>
                            <p class="lead">Change a Design</p>
                            <span> It has survived not only five centuries, but also the leap into electronic</span>
                        </div>
                        <div class="card-footer pt-0 border-0">
                            <a class="btn btn-sm btn-outline-secondary" href="#"><i
                                    class="fa fa-star favourite-note"></i></a>
                            <a class="btn btn-sm btn-outline-secondary" href="#"><i
                                    class="fa fa-trash favourite-note"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Notetab-Social" role="tabpanel">
                    <div class="card ribbon mb-2">
                        <div class="option-2 bg-dark position-absolute"></div>
                        <div class="card-body">
                            <span class="text-muted">22 August 2021</span>
                            <p class="lead">Nightout with friends</p>
                            <span>Blandit tempus porttitor aasfs. Integer posuere erat a ante venenatis.</span>
                        </div>
                        <div class="card-footer pt-0 border-0">
                            <a class="btn btn-sm btn-outline-secondary" href="#"><i
                                    class="fa fa-star favourite-note"></i></a>
                            <a class="btn btn-sm btn-outline-secondary" href="#"><i
                                    class="fa fa-trash favourite-note"></i></a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Notetab-Create" role="tabpanel">

                </div>

            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $(document).on('click', '.note-tap', function(e) {
            e.preventDefault()
            let buttonObj = $(this);
            let modelRoute = buttonObj.attr("data-url");
            let modalResult = $(".modal-body");
            $("#Notetab-Create", modalResult).html();
            console.log(modelRoute);
            $.ajax({
                url: modelRoute,
                type: 'GET',
                beforeSend: function() {},
                complete: function() {},
                success: function(result) {
                    $("#Notetab-Create", modalResult).html(result.data.html)
                    $('.rom-submit-global').reset();

                },
                error: function(errorObj, errorText, errorThrown) {
                    handleErrorResponce(errorObj);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.all-notes', function(e) {
            e.preventDefault()
            let buttonObj = $(this);
            let modelRoute = buttonObj.attr("data-url");
            let modalResult = $(".modal-body");
            $("#Notetab-all", modalResult).html();
            console.log(modelRoute);
            $.ajax({
                url: modelRoute,
                type: 'GET',
                beforeSend: function() {},
                complete: function() {},
                success: function(result) {
                    $("#Notetab-all", modalResult).html(result.data.html)
                },
                error: function(errorObj, errorText, errorThrown) {
                    handleErrorResponce(errorObj);
                }
            });
        });
    </script>
@endsection
