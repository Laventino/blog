@extends('layouts.app')

@section('content')
    @include('layouts.components.nav')
    @include('layouts.components.main-menu')
    @include('layouts.components.right-slider')

    <style>
        .note-page {
            position: absolute;
            height: calc(100vh - var(--nav-height));
            width: calc(100vw - var(--menu-width));
            margin: var(--nav-height) 0 0 var(--menu-width);
            overflow: auto;
            top:0;
        }

        .note-page .container {
            display: flex;
            background-image: repeating-linear-gradient(#282828 0%, #262626 45%, #242424 100%);
            position: relative;
            min-height: 100%;
            width: 100%;
            padding: 8px;
        }

        .note-page .container .column-container {
            width: 100%;
            position: relative;
            padding: 8px;
            color: white;
        }

        .note-page .container .column-container .item-wrapper {
            width: 100%;
            background-color: #424242;
            display: flex;
            padding: 12px 12px;
            flex-direction: column;
            border-radius: 2px;
        }

        .form-input {
            display: flex;
        }
        
        #input-note {
            flex: 1;
        }

        .note-container {

        }

        .note-table {
            background-color: #383838;
        }
        
        th {
            background-color: #343434;
        }

        td {
            padding: 1px 4px;
        }

        .action {
            width: 100px;
        }
        .note-text {
            max-width: 0px;
            /* width: 100%; */
            white-space: nowrap;
            position: relative;
            overflow: hidden;
            text-overflow: ellipsis;
            margin: 0
        }

        .mt-1 {
            margin-top: 1rem;
        }
        .mt-2 {
            margin-top: 2rem;
        }
        .mt-3 {
            margin-top: 3rem;
        }
        .mt-4 {
            margin-top: 4rem;
        }
        .mb-1 {
            margin-bottom: 1rem;
        }
    </style>
    <div class="note-page">
        <div class="container">
            <div class="column-container">
                <div class="item-wrapper mb-1">
                    <div class="form-input">
                        <input type="text" name="note" id="input-note">
                        <button id="add">Add</button>
                        <button id="add-copy">Add copy</button>
                    </div>
                </div>
                <div class="item-wrapper note-container">
                    <table class="note-table">
                        <tr id="table-header">
                            <th>Note</th>
                            <th class="action">Action</th>
                        </tr>
                        
                        @foreach ($note as $item)
                        <tr>
                            <td class="note-text">
                                {{ $item->value }}
                            </td>
                            <td>
                                <button class="delete" item-id="{{ $item->id }}">remove</button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function ajaxCustom(data_, url_, func_) {
            $.ajax({
                url: url_,
                data: data_,
                type: "POST",
                success: function(result) {
                    if (typeof func_ == "function") {
                        func_(result);
                    }
                }
            });
        }
        let newTrElement = null;
        let isProcessingAdd = false;
        $('#add').on('click', async function(){
            let inputNote = $('#input-note');
            let _this = $(this);
            if (inputNote.val()) {
                let str = `<tr>
                            <td class="note-text">
                                ${inputNote.val()}
                            </td>
                            <td>
                                <button class="delete" item-id="">remove</button>
                            </td>
                        </tr>`;
                tableHeader.after(str);
                newTrElement = tableHeader.next();
                if (isProcessingAdd == false) {
                    isProcessingAdd = true;
                    ajaxCustom({note: inputNote.val()}, '/note/add', function(res) {
                        isProcessingAdd = false;
                        newTrElement.find('.delete').attr('item-id', res)
                        newTrElement = null;
                        inputNote.val('');
                    });
                }
            }
        })

        let isProcessingDelete = false;
        $(document).on('click', '.delete', function(){
            let _this = $(this);
            if (isProcessingDelete == false) {
                isProcessingDelete = true;
                ajaxCustom({id: _this.attr('item-id')}, '/note/delete', function(res) {
                    isProcessingDelete = false;
                });
                _this.closest('tr').remove();
            }
        })
        $(document).on('click', '.note-text', function(){
            let _this = $(this);
            selectText($(this));
            copySelectedText();
        })
        
        function selectText(element) {
            var range = document.createRange();
            range.selectNode(element[0]); // Select the first element in the jQuery object
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }

        // Function to copy the selected text to clipboard
        function copySelectedText() {
            document.execCommand('copy');
            window.getSelection().removeAllRanges();
        }
        
        let tableHeader = $('#table-header');
        let isProcessingAddCopy = false;
        $('#add-copy').on('click', async function(){
            let _this = $(this);
            alert(navigator);
            const clipboardText = await navigator.clipboard.readText();
            let str = `<tr>
                            <td class="note-text">
                                ${clipboardText}
                            </td>
                            <td>
                                <button class="delete" item-id="">remove</button>
                            </td>
                        </tr>`;
            tableHeader.after(str);
            newTrElement = tableHeader.next();
            if (isProcessingAddCopy == false) {
                isProcessingAddCopy = true;
                ajaxCustom({note: clipboardText}, '/note/add', function(res) {
                    isProcessingAddCopy = false;
                    newTrElement.find('.delete').attr('item-id', res)
                    newTrElement = null;
                });
            }
        })
    </script>
@endsection
