<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a class="btn btn-tool btn-primary" href="{{ url('/core/page/register/') }}" role="button"><i
                            class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-condensed" style="width: 100%" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>App</th>
                            <th>Controller</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Page</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    var t;
    $(function () {
        t = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('core.page.data') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'icon', name: 'icon' },
                { data: 'app.name', name: 'name' },
                { data: 'controller', name: 'controller' },
                { data: 'action', name: 'action' },
                { data: 'name', name: 'name' },
                { data: 'type', name: 'type' },
                { data: 'page.name', name: 'name', defaultContent: "", "orderable": false },
            ],
        });
    });

    $.contextMenu({
        selector: '.context-menu',
        build: function ($trigger, e) {
            // this callback is executed every time the menu is to be shown
            // its results are destroyed every time the menu is hidden
            // e is the original contextmenu event, containing e.pageX and e.pageY (amongst other data)
            return {
                callback: function (key, options) {
                    var m = "clicked: " + key;
                    window.console && console.log(m) || alert(m);
                },
                items: {
                    "edit": { name: "Edit", icon: "edit" },
                    "cut": { name: "Cut", icon: "cut" },
                    "copy": { name: "Copy", icon: "copy" },
                    "paste": { name: "Paste", icon: "paste" },
                    "delete": { name: "Delete", icon: "delete" },
                    "sep1": "---------",
                    "quit": { name: "Quit", icon: function ($element, key, item) { return 'context-menu-icon context-menu-icon-quit'; } }
                }
            };
        }
    });
</script>
@endpush