import { createApp, defineComponent } from 'vue'
import { createPinia } from 'pinia'

import { Test } from '@component/test/'
import { MainLayout } from "@layout/main/";

const Root = defineComponent({
	name: 'Root',
	components: {
		MainLayout, Test
	},
	data: () => (window.__APP_DATA__),
	template: `
		<MainLayout>
			<Test/>
		</MainLayout>
	`,
})

const app = createApp(Root);
app.use(createPinia());
app.mount('#application');