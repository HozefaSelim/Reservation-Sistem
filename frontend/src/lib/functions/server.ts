import { promises as fs } from "fs";
import path from "path";

/**
 * Ensures a directory exists, creating it if necessary.
 * @param dirPath The directory path.
 */
async function ensureDirectoryExists(dirPath: string) {
  await fs.mkdir(dirPath, { recursive: true });
}

/**
 * Deletes a file if it exists.
 * @param filePath The file path.
 */
async function safeDeleteFile(filePath: string) {
  try {
    await fs.unlink(filePath);
  } catch (error) {
    if (error instanceof Error) {
      console.error(`Error deleting file: ${error.message}`);
    } else {
      console.error(`Error deleting file: ${error}`);
    }
  }
}

const saveImage = async (image: File) => {
  const uploadsDir = path.join(process.cwd(), "static/uploads/products");
  await fs.mkdir(uploadsDir, { recursive: true });

  const imageFileName = `${Date.now()}_${image.name}`;
  const imagePath = path.join(uploadsDir, imageFileName);
  await fs.writeFile(imagePath, Buffer.from(await image.arrayBuffer()));

  return `/uploads/products/${imageFileName}`;
};

const ServerResponse = async (
  messages: string,
  data: any[] | null = null,
  status = 200,
  code = 0
) => {
  return new Response(JSON.stringify({ code, message: messages, data }), {
    status,
  });
};

export { ensureDirectoryExists, safeDeleteFile, saveImage, ServerResponse };
