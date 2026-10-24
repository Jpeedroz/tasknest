@extends('layouts.app')

@section('header')
    
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-4">{{ __("Bem-vindo ao Sistema de Gestão de Tarefas!") }}</h3>
                        <p class="text-gray-600 mb-6">
                            {{ __("Organize suas atividades, acompanhe prazos e mantenha o foco.") }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Card para Ver Tarefas -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-blue-900">Minhas Tarefas</h4>
                                    <p class="text-blue-700">Visualize e gerencie todas as suas tarefas</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('tarefas.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Ver Tarefas
                                </a>
                            </div>
                        </div>

                        <!-- Card para Nova Tarefa -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-green-900">Nova Tarefa</h4>
                                    <p class="text-green-700">Crie uma nova tarefa rapidamente</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('tarefas.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Criar Tarefa
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Estatísticas rápidas (se houver tarefas) -->
                    @if(auth()->user()->tarefas()->count() > 0)
                        <div class="mt-8 border-t pt-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Resumo Rápido</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-gray-900">
                                        {{ auth()->user()->tarefas()->where('status', 'pendente')->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Tarefas Pendentes</div>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-blue-900">
                                        {{ auth()->user()->tarefas()->where('status', 'em_andamento')->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Em Andamento</div>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="text-2xl font-bold text-green-900">
                                        {{ auth()->user()->tarefas()->where('status', 'concluida')->count() }}
                                    </div>
                                    <div class="text-sm text-gray-600">Concluídas</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection