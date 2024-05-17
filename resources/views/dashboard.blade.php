<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-white">Dashboard</h2>
        </div>
    </x-slot>

    <div>
        <h1 class="text-4xl text-red-500 font-black">LES ACTUS RÉSEAUX</h1>
    </div>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container mx-auto px-4 py-4">
            <div class="test" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach($instagram as $post)
                    <div class="posts" style="padding: 2px; box-sizing: border-box;">
                        <div class="mb-4 flex flex-row items-center justify-start">
                            <x-application-logo class="block h-6 w-auto fill-current"/>
                            <span class="ml-4 text-sm font-bold">Aix Maurienne Savoie Basket</span>
                        </div>

                        @php
                            $caption = trim($post->caption ?? '');
                            if (empty($caption)) {
                                $caption = 'Instagram';
                            }
                            $formatted_caption = preg_replace('/#(\w+)/', '<span class="text-blue-500">#${1}</span>', $caption);
                        @endphp

                        <div class="caption" style="padding-bottom: 1rem; height: 50px; overflow: hidden;">
                            <p class="text-sm">{!! $formatted_caption !!}</p>
                        </div>

                        <a href="https://www.instagram.com/amsb_test/" target="_blank" style="display: block; height: 400px; overflow: hidden; position: relative;">
                            <div class="overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.4); opacity: 0; border-radius: 8px;"></div>
                            <img src="{{ $post->url }}" alt="Instagram Post" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <style>
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .test {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: -2px;
        }
        .posts {
            width: 33.3333%;
            height: 400px; /* Fixe la hauteur pour un aspect rectangulaire */
        }
        @media (max-width: 600px) {
            .posts {
                width: 100% !important;
                height: auto; /* Permet une meilleure responsivité sur les petits écrans */
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                const overlay = link.querySelector('.overlay');
                if (overlay) {
                    link.addEventListener('mouseenter', function() {
                        overlay.style.opacity = '1';
                    });
                    link.addEventListener('mouseleave', function() {
                        overlay.style.opacity = '0';
                    });
                }
            });
        });
    </script>

</x-app-layout>
