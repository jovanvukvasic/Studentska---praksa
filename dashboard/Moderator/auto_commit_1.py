import os
import random
import time
from datetime import datetime, timedelta
import sys

commit_messages = [
    "Dodana početna verzija fajla {file}",
    "Napravljena osnovna struktura u {file}",
    "Kreiran fajl {file} sa osnovnim elementima",
    "Dodan dio koda u {file}",
    "Sitne izmjene i dorade u {file}",
    "Formatiran kod u {file}",
    "Dodani komentari u {file} radi preglednosti",
    "Ispravljena manja greška u {file}",
    "Dorađen izgled i struktura u {file}",
    "Sitna poboljšanja u {file}",
    "Implementirana glavna logika u {file}",
    "Testiran dio funkcionalnosti u {file}",
    "Unesene korekcije u {file} nakon testiranja",
    "Dodani helper dijelovi u {file}",
    "Refaktorisan kod u {file}",
    "Dorađen kod i sitne promjene u {file}",
    "Završena implementacija u {file}",
    "Još par manjih izmjena u {file}",
    "Finalne dorade u {file}",
    "Završna verzija fajla {file}"
]

def split_file(lines):
    """Vrati header, body, footer linije (ako postoje)."""
    header, footer = [], []
    body = lines[:]

    for tag in ["</html>", "</body>", "?>"]:
        for i, line in reversed(list(enumerate(body))):
            if tag in line.lower():
                footer = body[i:]
                body = body[:i]
                break
        if footer:
            break

    for tag in ["<html", "<!doctype", "<?php"]:
        for i, line in enumerate(body):
            if tag in line.lower():
                header = body[:i+1]
                body = body[i+1:]
                break
        if header:
            break

    return header, body, footer


def simulate_commits(final_file, output_file, total_hours, total_commits):
    with open(final_file, "r", encoding="utf-8") as f:
        lines = f.readlines()

    header, body, footer = split_file(lines)

    if not footer:
        footer = ["\n", "// end of file\n"]

    chunks = []
    chunk_size = max(1, len(body) // total_commits)
    for i in range(0, len(body), chunk_size):
        chunks.append(body[i:i+chunk_size])

    if len(chunks) > total_commits:
        chunks = chunks[:total_commits]

    start_time = datetime.now()
    intervals = sorted([random.randint(0, total_hours*3600) for _ in range(total_commits)])
    intervals = [start_time + timedelta(seconds=i) for i in intervals]

    print(f" Planirano {total_commits} commitova tokom {total_hours}h")

    committed_body = []
    for i, t in enumerate(intervals):
        now = datetime.now()
        wait_time = (t - now).total_seconds()
        if wait_time > 0:
            print(f" Čekam {wait_time/60:.2f} minuta do commita {i+1}/{total_commits}...")
            time.sleep(wait_time)

        committed_body.extend(chunks[i])

        with open(output_file, "w", encoding="utf-8") as f:
            f.writelines(header + committed_body + footer)

        msg = random.choice(commit_messages).format(file=output_file)
        os.system("git fetch origin main")
        os.system("git merge -s ours origin/main")
        os.system(f"git add {output_file}")
        os.system(f'git commit -m "{msg}"')
        os.system("git push origin main")

        print(f" Commit {i+1}/{total_commits}: {msg}")

    print(" Gotovo! Fajl je kompletiran i podignut.")


if __name__ == "__main__":
    if len(sys.argv) != 5:
        print("Usage: python auto_commit.py <final_file> <output_file> <hours> <commits>")
        sys.exit(1)

    final_file = sys.argv[1]
    output_file = sys.argv[2]
    total_hours = int(sys.argv[3])
    total_commits = int(sys.argv[4])

    simulate_commits(final_file, output_file, total_hours, total_commits)
