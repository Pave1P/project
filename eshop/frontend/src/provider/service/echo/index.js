export async function echo(data: Object): Promise {
	const res = await fetch('/api/echo', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(data)
	})
	return res.json()
}