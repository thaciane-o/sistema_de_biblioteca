<x-layoutBase>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-6">
                <h1 class="mt-4">Página inicial</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Página inicial</li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <canvas id="qtd_livros_emprestimos"></canvas>
            </div>
            <div class="col-6">
                <canvas id="clientes_mais_emprestimos"></canvas>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <canvas id="faturamento_esse_mes"></canvas>
                <div class="alert alert-secondary">
                    <strong>Soma total de faturamentos esse mês:</strong> R$ {{ $totalEsseMes }}
                </div>
            </div>
            <div class="col-6">
                <canvas id="faturamento_mes_passado"></canvas>
                <div class="alert alert-secondary">
                    <strong>Soma total de faturamentos do mês passado:</strong> R$ {{ $totalMesPassado }}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Quantidade de vezes que o livro foi emprestado
        const emprestimos = {
            labels: @json(array_map(fn ($data) => $data->titulo, $qtdEmprestimos)),
            datasets: [{
                label: 'Quantidade de vezes que o livro foi emprestado',
                backgroundColor: 'rgba(13, 110, 253, 0.3)',
                borderColor: 'rgb(13, 110, 253)',
                data: @json(array_map(fn ($data) => $data->qtdEmprestado, $qtdEmprestimos)),
            }],
        };
        const configEmprestimos = {
            type: 'bar',
            data: emprestimos,
        };
        const graficoEmprestimos = new Chart(
            document.getElementById('qtd_livros_emprestimos'),
            configEmprestimos
        );

        // Faturamento do mes atual
        const faturamentoEsseMes = {
            labels: @json(array_map(fn ($data) => $data->titulo, $faturamentoEsseMes)),
            datasets: [{
                label: 'Total faturado esse mês',
                backgroundColor: 'rgba(13, 110, 253, 0.3)',
                borderColor: 'rgb(13, 110, 253)',
                data: @json(array_map(fn ($data) => $data->faturamento, $faturamentoEsseMes)),
            }],
        };
        const configfaturamentoEsseMes = {
            type: 'bar',
            data: faturamentoEsseMes,
        };
        const graficofaturamentoEsseMes = new Chart(
            document.getElementById('faturamento_esse_mes'),
            configfaturamentoEsseMes
        );

        // Faturamento do mês passado
        const faturamentoMesPassado = {
            labels: @json(array_map(fn ($data) => $data->titulo, $faturamentoMesPassado)),
            datasets: [{
                label: 'Total faturado mês passado',
                backgroundColor: 'rgba(13, 110, 253, 0.3)',
                borderColor: 'rgb(13, 110, 253)',
                data: @json(array_map(fn ($data) => $data->faturamento, $faturamentoMesPassado)),
            }],
        };
        const configfaturamentoMesPassado = {
            type: 'bar',
            data: faturamentoMesPassado,
        };
        const graficofaturamentoMesPassado = new Chart(
            document.getElementById('faturamento_mes_passado'),
            configfaturamentoMesPassado
        );

        // Clientes com mais emprestimos
        const clientesMaisEmprestimos = {
            labels: @json(array_map(fn ($data) => $data->nome, $clienteEmprestado)),
            datasets: [{
                label: 'Clientes com mais empréstimos',
                backgroundColor: 'rgba(13, 110, 253, 0.3)',
                borderColor: 'rgb(13, 110, 253)',
                data: @json(array_map(fn ($data) => $data->totalEmprestimos, $clienteEmprestado)),
            }],
        };
        const configclientesMaisEmprestimos = {
            type: 'bar',
            data: clientesMaisEmprestimos,
        };
        const graficoclientesMaisEmprestimos = new Chart(
            document.getElementById('clientes_mais_emprestimos'),
            configclientesMaisEmprestimos
        );
    </script>
</x-layoutBase>
