@extends('layouts.desktop')
@section('title', 'رسید خرید')
@section('body')
<div class="border-bottom">
    <div class="row">
        <div class="col-md-12">
            
            <div class="rounded shadow">
                <div class="text-center" style="background-color: #f1f1f1">
                    <h4 style="padding-top: 10px; color: #555">رسید خرید</h2>
                    <hr style="background-color: silver">
                </div>
                <div class="row" style="padding-bottom: 20px">
                    <div class="col-lg-12 col-md-4">
                        <div style="padding: 0 15px">
                        

                          
                            <form method="POST" action="{{route('desktop.buy.major.save')}}" enctype="multipart/form-data">
                                @csrf
                    
                            
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" id="submit" class="btn btn-primary">پرداخت </button>
                                    </div><!--end col-->
                                </div><!--end row-->

                            </form><!--end form-->
                        </div>
                    </div>
                </div><!--end row-->
            </div>
        </div><!--end col-->   
    </div><!--end row-->
</div>

@endsection