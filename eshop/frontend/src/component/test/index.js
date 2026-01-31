import "./styles.css";

import { ping } from '@service/ping'
import { echo } from '@service/echo'
import { randomizer } from '@service/randomizer'

export const Test = {
	name: 'Test',

	data() {
		return {
			loading: false,
			lastAction: '',
			result: null,
			error: null,
		}
	},

	methods: {
		async onPing() {
			this.loading = true
			this.lastAction = 'ping'
			this.result = null
			this.error = null

			try {
				const data = await ping()
				this.result = data
			} catch (e) {
				this.error = e?.message || String(e)
			} finally {
				this.loading = false
			}
		},

		async onRandomizer() {
			this.loading = true
			this.lastAction = 'randomizer'
			this.result = null
			this.error = null

			try {
				const data = await randomizer()
				this.result = data
			} catch (e) {
				this.error = e?.message || String(e)
			} finally {
				this.loading = false
			}
		},

		onEcho: async function () {
			this.loading = true
			this.lastAction = 'echo'
			this.result = null
			this.error = null
			try {
				const payload = {
					text: 'Hello from frontend',
					time: Date.now(),
				}
				const data = await echo(payload)

				this.result = data
			} catch (e) {
				this.error = e?.message || String(e)
			} finally {
				this.loading = false
			}

		},
	},

	template: `
    <main class="debug">
      <h2>Test application</h2>

      <div class="debug__actions">
        <button
          class="debug__button"
          type="button"
          @click="onPing"
          :disabled="loading"
        >
          Test (ping)
        </button>

        <button
          class="debug__button"
          type="button"
          @click="onEcho"
          :disabled="loading"
        >
          Echo
        </button>
		  
		  <button
			  class="debug__button"
			  type="button"
			  @click="onRandomizer"
			  :disabled="loading"
		  >
			  Random int
		  </button>  
		  
		  
      </div>

      <p v-if="loading" class="debug__status">Loading… ({{ lastAction }})</p>
      <pre v-if="result" class="debug__result">{{ JSON.stringify(result, null, 2) }}</pre>
      <pre v-if="error" class="debug__error">{{ error }}</pre>
    </main>
  `,
}