# F1FEVER API REST

This API provides comprehensive data on Formula 1 standings, drivers, constructors, circuits, grand prix information, lap times, race reports, and more.

Built with Laravel, this API relies on the **Ergast F1 MySQL database** to supply data.

<a href="https://ergast.com/mrd/">Ergast F1</a>

---

### Standings Routes

<details>
 <summary><code>GET</code> <code><b>/standings/drivers/{season?}</b></code> <code>Get driver standings by season</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  optional | integer        | The specified season year (e.g., 2022)     |

</details>

<details>
 <summary><code>GET</code> <code><b>/standings/constructors/{season?}</b></code> <code>Get constructor standings by season</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  optional | integer        | The specified season year (e.g., 2022)     |

</details>

---

### Grand Prix Routes

<details>
 <summary><code>GET</code> <code><b>/grand-prix/{name}/{season}</b></code> <code>Get specific grand prix information</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `name`            |  required | string         | Name of the grand prix                     |
> | `season`          |  required | integer        | The season year                            |

</details>

<details>
 <summary><code>GET</code> <code><b>/grand-prix/latest</b></code> <code>Get latest grand prix information</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/grand-prix/latest-preview</b></code> <code>Get preview of the latest grand prix</code></summary>
No parameters.
</details>

---

### Driver Routes

<details>
 <summary><code>GET</code> <code><b>/driver/{name}</b></code> <code>Get driver information by name</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `name`            |  required | string         | Driver's reference                         |

</details>

---

### Constructor Routes

<details>
 <summary><code>GET</code> <code><b>/constructor/{name}</b></code> <code>Get constructor information by name</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `name`            |  required | string         | Constructor's reference                    |

</details>

---

### Circuit Routes

<details>
 <summary><code>GET</code> <code><b>/circuit/{name}</b></code> <code>Get circuit information by name</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `name`            |  required | string         | Circuit's reference                        |

</details>

---

### Drivers List Routes

<details>
 <summary><code>GET</code> <code><b>/drivers</b></code> <code>Get list of all drivers</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/drivers/{season}</b></code> <code>Get list of drivers by season</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  required | integer        | The season year                            |

</details>

---

### Constructors List Routes

<details>
 <summary><code>GET</code> <code><b>/constructors</b></code> <code>Get list of all constructors</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/constructors/{season}</b></code> <code>Get list of constructors by season</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  required | integer        | The season year                            |

</details>

---

### Circuits List Routes

<details>
 <summary><code>GET</code> <code><b>/circuits</b></code> <code>Get list of all circuits</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/circuits/{season}</b></code> <code>Get list of circuits by season</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  required | integer        | The season year                            |

</details>

---

### Grand Prix List Routes

<details>
 <summary><code>GET</code> <code><b>/grand-prix-list/next</b></code> <code>Get next scheduled grand prix</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/grand-prix-list/current</b></code> <code>Get current season's grand prix rounds</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/grand-prix-list/season/{season?}</b></code> <code>Get grand prix rounds by season</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  optional | integer        | The season year                            |

</details>

<details>
 <summary><code>GET</code> <code><b>/grand-prix-list/name/{name}</b></code> <code>Get grand prix rounds by name</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `name`            |  required | string         | Name of the grand prix                     |

</details>

---

### Lap Times Routes

<details>
 <summary><code>GET</code> <code><b>/lap-times/{season}/{grandprix}/{driver}</b></code> <code>Get lap times for a driver</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  required | integer        | The season year                            |
> | `grandprix`       |  required | string         | Grand prix name                            |
> | `driver`          |  required | string         | Driver's reference                         |

</details>

---

### Race Report Routes

<details>
 <summary><code>GET</code> <code><b>/race-report/{season}/{grandprix}/{driver}</b></code> <code>Get race report for a driver</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  required | integer        | The season year                            |
> | `grandprix`       |  required | string         | Grand prix name                            |
> | `driver`          |  required | string         | Driver's reference                         |

</details>

---

### Analysis Routes

<details>
 <summary><code>GET</code> <code><b>/analysis/seasons</b></code> <code>Get list of seasons for analysis</code></summary>
No parameters.
</details>

<details>
 <summary><code>GET</code> <code><b>/analysis/grand-prix/{season}</b></code> <code>Get grand prix in a season for analysis</code></summary>

##### Parameters

> | name              |  type     | data type      | description                                |
> |-------------------|-----------|----------------|--------------------------------------------|
> | `season`          |  required | integer        | The season year                            |

</details>

---

### Seasons List Routes

<details>
 <summary><code>GET</code> <code><b>/seasons</b></code> <code>Get all available seasons</code></summary>
No parameters.
</details>

---
