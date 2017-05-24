@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="panel panel-info">
            <div class="panel-heading">
                <h1 class="panel-title">Shop</h1>
            </div>
            <div class="panel-body">
                @foreach($items as $item)
                    <item class="hvr-glow" :attributes="{{ $item }}" :ownCoin="{{ $coin }}" inline-template v-cloak>
                        <div class="col-sm-4 col-lg-4 col-md-4">
                            <div class="thumbnail">
                                <img src="{{ $item->image }}" alt="{{ $item->display_name }}">
                                <div class="caption">
                                    <h4 class="pull-right">{{ $item->features['cost'] }} coin</h4>
                                    <h4>{{ $item->display_name }}</h4>
                                    <hr>
                                    <p>{{ $item->description }}</p>
                                    <hr>
                                </div>
                                <div class="ratings">
                                    <p class="pull-right">
                                        <button class="btn btn-primary" @click="buyItems">Buy</button>
                                    </p>
                                    <p>
                                        <item-quantity></item-quantity>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </item>
                @endforeach
            </div>
        </div>
    </div>



@endsection