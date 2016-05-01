
	{!! Form::open(array('action'=>'PageController@store'))!!}
	    First Name {!! Form::text('first_name')!!}
	    Last Name {!! Form::text('last_name')!!}
	    {!! Form::submit('save') !!}
	{!! Form::close() !!}

<!-- {!! Form::open() !!}
    Product Code {!! Form::text('PID', 'product_code') !!}<br/><br/>
    Product Name {!! Form::text('PName', 'name') !!}<br/><br/>
    Product Price {!! Form::number('Pprice') !!}<br/><br/>
    Product Category {!! Form::text('Pcate', 'cate') !!}<br/><br/>
    product original {!! Form::radio('orignal','local') !!}<br/><br/>
    product original {!! Form::radio('orignal','internationl') !!}<br/><br/>
    product image {!! Form::file('image') !!}<br/><br/>
    product name {!! Form::selectRange('number', 10, 20) !!}<br/><br/>
    Size {!!Form::select('size', array('L' => 'Large', 'S' => 'Small'))!!}<br/><br/>
    Password {!!Form::password('password')!!}<br/><br/>
    product original {!! Form::radio('orignal','internationl') !!}<br/><br/>
	{!! Form::submit('submit') !!}
 {!! Form::close()!!}
 -->

