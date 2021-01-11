@extends('layouts.admin_layout')

@section('content')


    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div
                        class="d-sm-flex d-md-block d-xl-flex flex-row flex-wrap text-center text-sm-left align-items-center">
                        <img src="{{asset('admin/img/face11.jpg')}}" class="img-lg rounded" alt="profile image"/>
                        <div class="ml-sm-3 ml-md-0 ml-xl-3 mt-2 mt-sm-0 mt-md-2 mt-xl-0">
                            <h6 class="mb-0">{{$userInfo->name}}</h6>
                            <p class="text-muted mb-1">{{$userInfo->email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row toggle_project_div" id="div_ra_row" style="display: block;">
        <div class="col-md-12 col-sm-12 col-xs-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <ul class="tree-list">
                        <li>
                            <span class="tree_toggler">
                            <i class="mdi mdi-folder-multiple-outline"> </i> &nbsp; Applications</span>
                            <?php

                            $storageDirectory = 'public/applications/' . Illuminate\Support\Facades\Auth::user()->company_name . '/pdf/';
                            $directories = array_sort(\Illuminate\Support\Facades\Storage::directories($storageDirectory), function($file)
                            {
                                return filectime(storage_path('app/' .$file));
                            });

                            $applicationList = array_reverse($directories, true);


                            ?>

                            <ul class="nestedx">
                                @foreach($applicationList as $application)
                                    <?php
                                    $directoryURL = storage_path('app/' . $application);

                                    ?>

                                    <?php

                                    //$childList = array_map('basename', Illuminate\Support\Facades\Storage::files($storageDirectory . $application . '/'));
                                    $childList = array_sort(\Illuminate\Support\Facades\Storage::files($application), function($file)
                                    {
                                        return filectime(storage_path('app/' .$file));
                                    });

                                    $childList = array_reverse($childList, true);

                                    ?>
                                    @if(count($childList) > 0)
                                        <li>
                                           <span class="tree_toggler"><i class="mdi mdi-folder-multiple-outline"></i>&nbsp;{{basename($application)}}
                                               <span class="directory-right">
                                                   <span
                                                       class="mr-3">{{date('d M Y',filectime($directoryURL) )}}</span>
                        <form id="" class="download-folder-form" method="POST"
                              action="{{route('application.delete')}}"
                              enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                            <input type="hidden" name="fullPath" value="{{$application}}">
                            <input type="hidden" name="folder_name" value="{{basename($application)}}">
                            <button type="submit" class="link-btn-form" title="Delete Folder"><i
                                    class="mdi mdi-delete-forever"></i></button>
                        </form>
                                                   <form id="" class="download-folder-form" method="POST"
                                                         action="{{route('application.zip')}}"
                                                         enctype="multipart/form-data" data-parsley-validate>
                        @csrf
                            <input type="hidden" name="fullPath" value="{{$application}}">
                            <input type="hidden" name="folder_name" value="{{basename($application)}}">
                            <button type="submit" class="link-btn-form" title="Save as Zip"><i
                                    class="mdi mdi-folder-download"></i></button>
                        </form>


                                               </span>

                            </span>


                                            <ul class="nested">
                                                @foreach($childList as $fileItem)

                                                    <li>
                                                        <form class="three-four" method="POST"
                                                              action="{{route('application.single.download')}}"
                                                              enctype="multipart/form-data" data-parsley-validate>
                                                            @csrf
                                                            <input type="hidden" name="fullPath"
                                                                   value="{{$application.'/'.basename($fileItem)}}"/>
                                                            <button type="submit" class="btn-directory-file"><i
                                                                    class="mdi mdi-file"></i>&nbsp;{{basename($fileItem)}}
                                                            </button>

                                                        </form>

                                                        <form id="" class="one-four" method="POST"
                                                              action="{{route('application.file.delete')}}"
                                                              enctype="multipart/form-data" data-parsley-validate>
                                                            @csrf


                                                            <span class="directory-right">
                                                        @php
                                                            $fileURL = storage_path('app/' . $application.'/'.basename($fileItem));
                                                        @endphp
                                                        <span
                                                            class="mr-3">{{date('d M Y',filectime($fileURL) )}}</span>
                                                            <button type="submit" class="link-btn-form"
                                                                    title="Delete File"><i
                                                                    class="mdi mdi-delete-forever"></i></button>
                                                    </span>
                                                            <input type="hidden" name="fullPath"
                                                                   value="{{$application.'/'.basename($fileItem)}}">
                                                            <input type="hidden" name="folder_name"
                                                                   value="{{basename($application)}}">

                                                        </form>


                                                    </li>
                                                @endforeach
                                            </ul>

                                        </li>

                                    @endif
                                @endforeach

                            </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>



    <script type="text/javascript">

        $(document).ready(function () {

            ActiveLeftSideMenuOnLoad(".application_menu", 0);

            var successMessage = '{{ session()->get("message") }}';
            if ($.trim(successMessage) != "")
                showSwal('success-message', successMessage);

            ActiveLeftSideMenuOnLoad(".job_nav ", 4);

            var toggler = document.getElementsByClassName("tree_toggler");
            var i;

            for (i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function () {
                    this.parentElement.querySelector(".nested").classList.toggle("active");
                    this.classList.toggle("caret-down");
                });
            }

        });


    </script>

@endsection
