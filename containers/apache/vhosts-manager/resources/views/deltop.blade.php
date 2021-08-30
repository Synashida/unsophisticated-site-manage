@extends('common.layout')

@section('contents')

<div class="row">
    <div class="col-xs-12">
        <div class="content-box-large">
            <div class="panel-heading">
                <div class="panel-title">削除確認</div>
            </div>
            <div class="panel-body">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="frm" action="/delete/exec" method="POST">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-danger">
                                削除完了時に下記DocumentRootに表示されているディレクトリも削除されます。<br>
                                削除されて問題がある場合は必ずバックアップを取っておいてください。<br>
                                完了後はhostsから対象のドメインの行を削除するようにしてください。
                            </div>
                        </div>
                    </div>
                    @csrf
                    <div class="form-group @error('domain_name') has-error @enderror">
                        <span>削除対象:</span>
                        <span style="padding-left: 3px; font-weight: bold;">{{ $targetHost['domain_name'] }}</span>
                        <br>
                        <span>DocumentRoot:</span>
                        <span style="padding-left: 3px; font-weight: bold;">{{ $targetHost['document_root'] }}</span>
                        <input type="hidden" name="domain_name" class="form-control"
                            value="{{ $targetHost['domain_name'] }}">
                        @error('domain_name')
                        <span class="help-block"><i class="fa fa-warning"></i> {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-danger"
                            onclick="if (confirm('本当に削除を実行しても良いですか？')) { $('#loading').css('visibility', 'visible'); setTimeout('$(\'#frm\').submit();', 100); } else { return false;}">削除する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection