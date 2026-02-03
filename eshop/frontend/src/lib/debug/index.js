import {ping} from "@service/ping";
import {simpleAlert} from "@lib/notification";
import {echo} from "@service/echo";

export function pingTest()
{
	ping().then(data => simpleAlert(JSON.stringify(data)));
}

export async function echoTest(data) {
	echo(data).then(console.log)
}