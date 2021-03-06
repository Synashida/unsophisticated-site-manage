@extends('common.layout')

@section('contents')

<div class="row">
    <div class="col-xs-12">
        <div class="content-box-large">
            <div class="panel-heading">
                <div class="panel-title">新規追加</div>
            </div>
            <div class="panel-body">

                @if ($execute_result_type == 'add' && $execute_result_status == 1)
                <div class="alert alert-success">
                    <div style="font-weight: bold">登録完了しました。</div>
                    <div>hostsに下記レコードを追加してからブラウザからアクセスをお願いします。</div>
                    <div>---hosts追記---<br>127.0.0.1 {{ $execute_result_domain }}<br>---hosts追記---</div>
                    <div>このリンクをクリックして、サイトの追加を確認<br>
                        <a target="_blank" href="http://{{ $execute_result_domain }}:8000/">
                            http://{{ $execute_result_domain }}:8000/
                        </a>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form id="frm" action="/add/store" method="POST">
                    @csrf
                    <div class="form-group col-xs-12 @error('domain_name') has-error @enderror">
                        <label class="form-label">ドメイン名</label>
                        <input type="text" name="domain_name" class="form-control" placeholder="検証ドメイン名を入力してください"
                            value="{{ old('domain_name') }}">
                        @error('domain_name')
                        <span class="help-block"><i class="fa fa-warning"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-xs-3 @error('use_wp') has-error @enderror">
                        <label class="form-label">wordpressを利用する</label>
                        <input type="checkbox" name="use_wp" class="form-control" value="1"
                            onclick="$('#db_name').attr('readonly', !$(this).prop('checked'));" @if (old('use_wp'))
                            checked="checked" @endif>
                        @error('use_wp')
                        <span class="help-block"><i class="fa fa-warning"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-xs-9 @error('db_name') has-error @enderror">
                        <label class="form-label">DB名</label>
                        <input type="text" name="db_name" id="db_name" @if (!old('use_wp')) readonly="readonly" @endif
                            class="form-control" placeholder="DB名を半角英数で入力してください。" value="{{ old('db_name') }}">
                        @error('db_name')
                        <span class="help-block"><i class="fa fa-warning"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-xs-12">
                        <button type="button" class="btn btn-primary"
                            onclick="if (confirm('作成します。よろしいですか？')) { $('#loading').css('visibility', 'visible'); setTimeout('$(\'#frm\').submit();', 100); } else { return false; }">作成する</button>
                    </div>
                </form>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="alert alert-info">
                            <span style="font-size: 1.1em; font-weight: bold;">登録完了後、hostsファイルに 以下の記述を追記してください。</span>
                            <br>
                            <br>
                            <span style="padding: 10px 15px;">127.0.0.1 [入力したドメイン名]</span>
                            <br>
                            <br>
                            すでにhostsファイルに 127.0.0.1の記載があっても消さずに、そのままにしておいてください。<br>
                            (重複しても正常に動作します)<br>
                            <br>
                            hostsファイルの場所は以下になります。<br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>OS</th>
                                        <th>パス</th>
                                        <th>修正方法</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Windows</td>
                                        <td>C:\Windows\System32\drivers\etc\hosts</td>
                                        <td>メモ帳などのテキストエディタで修正してください。</td>
                                    </tr>
                                    <tr>
                                        <td>Mac</td>
                                        <td>/etc/hosts</td>
                                        <td>sudo vi /etc/hosts をターミナルから実行して修正してください。</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection