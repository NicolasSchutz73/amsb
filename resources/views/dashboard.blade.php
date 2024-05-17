<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="mb-1 font-semibold text-xl text-white">
                Dashboard
            </h2>
        </div>
    </x-slot>

    @if(isset($error))
        <p class="text-red-500">{{ $error }}</p>
    @else
        <div class="container mx-auto px-4 py-4" style="max-width: 1200px; margin: auto;">
            <div class="test" style="display: flex; justify-content: center; flex-wrap: wrap;">
                @foreach($instagram as $post)
                    <div class="posts" style="padding: 2px; box-sizing: border-box;">
                        <div class="mb-4 flex flex-row items-center justify-start">
                            <x-application-logo class="block h-6 w-auto fill-current"/>
                            <span class="ml-4 text-sm font-bold">Aix Maurienne Savoie Basket</span>
                        </div>

                        <div class="caption" style="padding-bottom: 1rem;">
                            <p class="text-sm">{{$post->caption}}</p>
                        </div>
                        <a href="https://www.instagram.com/amsb_test/" target="_blank" style="display: block; height: 300px; overflow: hidden; position: relative;">
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
        }
        @media (max-width: 600px) {
            .posts {
                width: 100%; !important;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const links = document.querySelectorAll('a');

            links.forEach(link => {
                const overlay = link.querySelector('.overlay');

                if (overlay) {
                    // Ajoute l'effet de survol
                    link.addEventListener('mouseenter', function() {
                        overlay.style.opacity = '1';
                    });

                    // Retire l'effet lorsque la souris quitte le lien
                    link.addEventListener('mouseleave', function() {
                        overlay.style.opacity = '0';
                    });
                }
            });
        });
    </script>

</x-app-layout>

