<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts._head')
    </head>
    <body class="min-h-screen">
        <div class="grid min-h-screen lg:grid-cols-2">
            {{-- Painel da marca: só aparece em telas grandes --}}
            <aside class="brand-panel hidden lg:flex" aria-hidden="true">
                <x-logo :inverted="true" />

                <div>
                    <h2 class="max-w-lg text-balance text-[40px] font-semibold leading-[1.1] tracking-tight">
                        Do pendente ao concluído, sem perder o fluxo.
                    </h2>
                    <p class="mt-4 max-w-md text-pretty text-lg leading-relaxed text-white/75">
                        Organize suas tarefas em um quadro simples, com prioridades e progresso sempre à vista.
                    </p>

                    {{-- Prévia ilustrativa do quadro --}}
                    <div class="glass mt-10 max-w-md space-y-2.5 rounded-2xl p-4">
                        <div class="flex items-center gap-2 px-1 text-xs font-medium text-white/80">
                            <span class="size-2 rounded-full bg-indigo-300"></span>
                            Em progresso
                            <span class="ml-auto rounded-full bg-white/15 px-2 py-0.5">2</span>
                        </div>
                        <div class="rounded-xl bg-white/95 p-3.5 text-slate-900 shadow-lg">
                            <p class="text-sm font-semibold">Mapear rotas de entrega da zona sul</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium leading-none text-rose-700">
                                    <span class="size-1.5 rounded-full bg-rose-500"></span> Alta
                                </span>
                                <span class="text-xs text-slate-500">há 2 horas</span>
                            </div>
                        </div>
                        <div class="rounded-xl bg-white/80 p-3.5 text-slate-900 shadow-lg">
                            <p class="text-sm font-semibold">Configurar alertas de atraso</p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium leading-none text-amber-800">
                                    <span class="size-1.5 rounded-full bg-amber-500"></span> Média
                                </span>
                                <span class="text-xs text-slate-500">ontem</span>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-white/80">
                    <li class="flex items-center gap-2"><x-icon name="check-circle" class="size-4" /> Quadro por status</li>
                    <li class="flex items-center gap-2"><x-icon name="flag" class="size-4" /> Prioridades</li>
                    <li class="flex items-center gap-2"><x-icon name="trending" class="size-4" /> Progresso à vista</li>
                </ul>
            </aside>

            <main class="flex min-h-screen flex-col items-center justify-center px-6 py-12 sm:px-12">
                <div class="w-full max-w-[400px]">
                    <a href="{{ url('/') }}" class="mb-10 inline-flex lg:hidden" aria-label="TaskFlow — início">
                        <x-logo />
                    </a>

                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
