try {
  await import("http://[::1]:5177/panel/index.js");
} catch (err) {
  console.error(
    "[kirbyup] Couldn't connect to the development server. Run `npm run serve` to start Vite or build the plugin with `npm run build` so Kirby uses the production version."
  );
  throw err;
}
