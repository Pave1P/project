export async function ping(): Promise {
	const res = await fetch('/api/ping')
	return res.json()
}