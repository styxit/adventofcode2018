# Advent of Code 2018
Advent of Code 2018 solutions. https://adventofcode.com/

## 🛠 Setup
- `composer install`

## 💻 Usage
To get the solution for day 2, run.
```
 ./aoc solve 2
```

##️ 👷 Adding a new solution
To create a new solution for day `28` do the following (replace 28 with the number of your day):
- Store the input in `inputs/day28.txt`.
- Create a new Solution for the day `days/Day28/Solution.php` That extends `Styxit\AbstractSolution`.
- Write the execute method that returns the final solution.

In the Solution class, you can use `$this->input` to get access to the parsed input that belongs to the same day.

Run you puzzle with
```
 ./aoc solve 28
```
