@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header">
                <h2 class="card-title">Kuisioner Peserta</h2>
            </div>
            <div class="card-body">
                <!-- Dropdown untuk Daftar Peserta -->
                <div class="mb-3">
                    <label for="participant-select" class="form-label">Pilih Peserta:</label>
                    <select class="form-select" id="participant-select" onchange="loadParticipantDetails()">
                        <option value="" disabled selected>Pilih nama peserta</option>
                        @foreach($participants as $participant)
                        <option value="{{ route('questionnaire.participants', $participant->id) }}">{{
                            $participant->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Detail Kuisioner -->
                <div id="details-container" class="mt-4" style="display: none;">
                    <h3>Detail Kuisioner untuk: <span id="participant-name"></span></h3>

                    <!-- Detail informasi peserta -->
                    <div class="participant-details">
                        <div class="detail-item">
                            <strong>NIM:</strong> <span id="participant-nim"></span>
                        </div>
                        <div class="detail-item">
                            <strong>Jurusan:</strong> <span id="participant-jurusan"></span>
                        </div>
                        <div class="detail-item">
                            <strong>Jenis Kelamin:</strong> <span id="participant-jenis-kelamin"></span>
                        </div>
                        <div class="detail-item">
                            <strong>Email:</strong> <span id="participant-email"></span>
                        </div>
                        <div class="detail-item">
                            <strong>Mitra:</strong> <span id="participant-mitra"></span>
                        </div>
                        <div class="detail-item">
                            <strong>Lowongan:</strong> <span id="participant-lowongan"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-header">
                <h2 class="card-title">Jawaban Peserta</h2>
            </div>
            <div class="card-body">
                <!-- Menggunakan Flexbox untuk layout jawaban kuisioner -->
                <div id="questionnaire-responses" class="responses-container">
                    <!-- Isi akan dimasukkan oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .participant-details {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 20px;
    }

    .detail-item {
        flex: 1 1 45%;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .detail-item strong {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }

    .detail-item span {
        color: #555;
    }

    .responses-container {
        margin-top: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .response-item {
        background: #e9ecef;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .response-item strong {
        display: block;
        margin-bottom: 5px;
        color: #333;
    }
</style>

<script>
    function loadParticipantDetails() {
        var select = document.getElementById('participant-select');
        var url = select.value;

        if (url) {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('participant-name').textContent = data.nama_peserta;
                        document.getElementById('participant-nim').textContent = data.nim;
                        document.getElementById('participant-jurusan').textContent = data.jurusan;
                        document.getElementById('participant-jenis-kelamin').textContent = data.jenis_kelamin;
                        document.getElementById('participant-email').textContent = data.email;
                        document.getElementById('participant-mitra').textContent = data.mitra;
                        document.getElementById('participant-lowongan').textContent = data.lowongan;

                        var responsesContainer = document.getElementById('questionnaire-responses');
                        responsesContainer.innerHTML = '';

                        // Loop melalui setiap respon dan buat elemen rapi
                        data.responses.forEach(function(response) {
                            response.question.forEach((question, index) => {
                                var responseItem = document.createElement('div');
                                responseItem.className = 'response-item';

                                var questionElem = document.createElement('strong');
                                questionElem.textContent = 'Pertanyaan: ' + question;
                                responseItem.appendChild(questionElem);

                                var answerElem = document.createElement('p');
                                answerElem.textContent = 'Jawaban: ' + response.answer[index];
                                responseItem.appendChild(answerElem);

                                var createdAtElem = document.createElement('p');
                                createdAtElem.textContent = 'Dibuat pada: ' + response.created_at;
                                responseItem.appendChild(createdAtElem);

                                responsesContainer.appendChild(responseItem);
                            });
                        });

                        document.getElementById('details-container').style.display = 'block';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }
</script>
@endsection