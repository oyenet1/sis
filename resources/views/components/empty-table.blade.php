<div class="flex flex-col items-center justify-center w-full py-8 my-auto space-y-4 rounded-lg">
	<img src="/img/empty_table.svg" alt="fees" class="w-36">
	<div class="mx-auto space-y-2 text-center">
		<h1 class="text-2xl font-semibold capitalize lg:text-3xl 2xl:text-4xl">{{ 'no ' . $title . ' yet' }}</h1>
		{{ $slot }}
	</div>
</div>
