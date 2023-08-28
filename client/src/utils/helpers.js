export function parseNumeric(value) {
	value = `${value}`.trim();

	let parts = value.replace(/[^\d\.]+/, "").split(".");

	value = parts[0];

	if (parts[1] === "" || parseInt(parts[1])) {
	  value = `${value}.${parts[1]}`;
	}

	return value;
}