<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>CSV Uploader</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <style>
        #user_list, th {
            text-align: center;
        }
        .container {
            margin-top: 20px;
        }
        #search, #upload {
            width: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="input-group mb-3" id="upload">
            <div class="input-group-prepend">
              <button class="btn btn-outline-primary" type="button" id="uploadBtn">Upload</button>
            </div>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="excelUpload" id="fileUploadBtn">
              <label class="custom-file-label fileLabel" for="fileUploadBtn">Choose file...</label>
            </div>
        </div>
    
        <div class="input-group mb-3" id="search">
            <div class="input-group-prepend">
                <button class="btn btn-outline-primary" type="button" id="searchBtn">Search</button>
            </div>
            <select class="custom-select" id="selectSearchKey" title="selectSearchKey">
                <option selected>Search By...</option>
                <option value="year">Year</option>
                <option value="rank">Rank</option>
                <option value="recipient">Recipient</option>
                <option value="country">Country</option>
                <option value="career">Career</option>
                <option value="tied">Tied</option>
                <option value="title">Title</option>
            </select>
            <div class="input-group-prepend">
                <input type="text" class="custom-select" id="selectSearchValue" style="background: none !important;">
            </div>
        </div>
          
        @yield('table')
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
</body>
</html>