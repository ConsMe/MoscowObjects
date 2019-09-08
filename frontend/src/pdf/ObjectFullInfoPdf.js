import * as JsPDF from 'jspdf';

export default async () => {
  const doc = new JsPDF({
    orientation: 'landscape',
  });
  doc.text('Hello world!', 10, 10);
  const response = await fetch('https://static-maps.yandex.ru/1.x/?ll=37.620070,55.753630&size=450,450&z=13&l=map&pt=37.620070,55.753630,pmwtm1~37.64,55.76363,pmwtm99');
  const reader = response.body.getReader();
  let receivedLength = 0;
  const chunks = [];
  while (true) {
    const { done, value } = reader.read();
    if (done) {
      break;
    }
    chunks.push(value);
    // receivedLength += value.length;
  }
  await Promise.all(chunks);
  console.log(chunks);
  return;
  const chunksAll = new Uint8Array(await Promise.all(receivedLength));
  let position = 0;
  for (let chunk of chunks) {
    chunksAll.set(chunk, position);
    position += chunk.length;
  }
  let result = new TextDecoder("utf-8").decode(chunksAll)
  console.log(result);
};
