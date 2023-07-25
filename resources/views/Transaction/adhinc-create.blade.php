@extends('../layouts.master')
@section('content')
<style>
    .po-head{
        background-color: #007bff;
        border-color: #007bff;
        color: #ffffff;
    }
    .po-main {
        margin-left: 16px;
    }
</style>
<div class="container-fluid">
    <div class="card shadow mt-3">
        <div class="card-body">
            <!-- First Row -->
            <div class="row">
                <div class="col-md-10 po-head">
                    <h3 class="po-main text-bold text-uppercase mt-3">Purchase Order</h3>    
                </div>
                <div class="col-md-2 po-head">
                    <select class="form-group mt-3" name="category" id="category">
                        <option selected="" disabled="" value="0">₹</option> 
                        <option value="0">US$</option> 
                        <option value="0">£</option> 
                        <option value="0">€</option>  
                        <option value="0">¥</option>  
                        <option value="0">₹ (Exp)</option>  
                        <option value="0">A$</option>  
                        <option value="0">AED</option>  
                        <option value="0">CA$</option>  
                        <option value="0">R$</option>  
                    </select>
                </div>
            </div>
            <!-- Second Row -->
            <div class="row">
                <div class="col-md-9">
                    <!-- First Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- First Card -->
                            <div class="card w-25">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- First Card -->
                            <div class="card w-25">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Second Row -->
                    <div class="row">
                        <div class="col-md-6">
                            <!-- First Card -->
                            <div class="card w-25">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- First Card -->
                            <div class="card w-25">
                                <div class="card-body">
                                    <h5 class="card-title">Special title treatment</h5>
                                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card" style="width: 25rem;">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">An item</li>
                                <li class="list-group-item">A second item</li>
                                <li class="list-group-item">A third item</li>
                            </ul>
                        <div class="card-body">
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection