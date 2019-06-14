# Print list of image filenames so I can easily copy and paste into Edit Album form

import os

for entry in os.scandir(path='cover-art/'):
    if entry.is_file():
        print(entry.name)