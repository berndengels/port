@extends('layouts.main')

@section('main')
    <div class="align-content-center">
        <div class="clearfix">
            <div class="float-start">
                <x-btn-back route="{{ route('admin.contacts.index') }}" />
            </div>
            <div class="float-end">
            </div>
        </div>
        <div class="row py-1 mt-3">
            <div class="col-2">Eingang</div>
            <div class="col-auto">{{ $contact->created_at->format('d.m.Y H:i') }}</div>
        </div>
        <div class="row py-1">
            <div class="col-2">Name</div>
            <div class="col-auto">{{ $contact->name }}</div>
        </div>
        <div class="row py-1">
            <div class="col-2">Email</div>
            <div class="col-auto"><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></div>
        </div>
        <div class="row py-1">
            <div class="col-2">Betreff</div>
            <div class="col-auto">{{ $contact->subject }}</div>
        </div>
        <div class="row py-1">
            <div class="col-2">Nachricht</div>
            <div class="col-auto">{{ $contact->message }}</div>
        </div>
    </div>
@endsection
