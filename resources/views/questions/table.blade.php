<div class="box-header">
    <div class="row">
        <form action="/questions" method="get" class="col-md-3 pull-right">
            <div class="input-group input-group-md">
                <input type="text" name="search" class="form-control" placeholder="Search Title">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary btn-flat">Search</button>
                </span>
            </div>
        </form>
    </div>
</div>
<table id="datatable" class="table table-bordered" cellspacing="0">
    <thead>
        <tr>
            <th>Title</th>
            <th>Survey Type</th>
            <th>No. of Answers</th>
            <th class="col-action">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
            <tr>
                <td> {{ str_limit(strip_tags($question->title), 40) }} </td>
                <td> {{ ucwords($question->survey->type) }}</td>
                <td> {{ $question->answers_count }} </td>
                <td>
                    <a class="link-btn" href="/questions/{{ $question->id }}" title="View">
                        <button type="button" class="btn btn-primary">
                            <span class="glyphicon glyphicon-circle-arrow-right" aria-hidden="true"></span>
                        </button>
                    </a>
                    <form action="/questions/{{ $question->id }}" method="post" class="form-btn">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete question? This will delete all results linked to this question.')">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="pull-right">
    {{ $questions->links() }}
</div>
