export async function randomizer(data: Object): Promise {
    const res = await fetch('/api/randomizer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .catch(console.error)
    return res.json()
}