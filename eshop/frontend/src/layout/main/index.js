import "@css/reset.css";
import "@css/styles.css";

export const MainLayout = {
	name: 'MainLayout',
	template: `
         <main class="wrap">
			<section class="card">
				<header class="card__header">
				<h1 class="card__title">Планировщик фильмов</h1>
				<p class="card__subtitle">Вариант практики: инициализация приложения + внешний компонент</p>
				</header>
				<section><slot></slot></section>
			</section>
		</main>
    `,
}


