<!-- Title Field -->
<div class="form-group">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>
<!--- Body Field --->
<div class="form-group">
    {!! Form::label('body', 'Body:') !!}
    <div class="editor">
        {!! Form::textarea('body', null, ['class' => 'form-control', 'id'=>'myEditor']) !!}
    </div>
</div>