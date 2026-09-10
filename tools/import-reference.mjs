import { readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { fileURLToPath } from 'node:url';

const input = process.argv[2];
if (!input) throw new Error('Usage: node tools/import-reference.mjs collection.json');
const document = JSON.parse(readFileSync(input, 'utf8'));
const operations = [];
function visit(items, parents = []) {
    for (const item of items ?? []) {
        if (item.item) {
            visit(item.item, [...parents, item.name]);
            continue;
        }
        const request = item.request;
        if (!request || request.method === 'VIEW') continue;
        if (typeof request.url !== 'string') throw new Error('Unexpected URL format');
        const path = request.url.replace('{{Base-URL}}', '').split('?')[0];
        if (!path.startsWith('/')) throw new Error('Unexpected path: ' + path);
        operations.push({ name: [...parents, item.name].join(' / '), method: request.method, path });
    }
}
visit((document.collection ?? document).item);
const output = fileURLToPath(new URL('../tests/fixtures/endpoints.json', import.meta.url));
mkdirSync(fileURLToPath(new URL('../tests/fixtures', import.meta.url)), { recursive: true });
writeFileSync(output, JSON.stringify({
    source: 'https://documenter.getpostman.com/view/21611004/UzBqnPvF',
    operations,
}, null, 2) + '\n');
console.log(`Imported ${operations.length} documented request examples.`);