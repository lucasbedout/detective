## Format per type (examples with a classic class prop)

    # Integer 

        param=1 (also works for boolean)
        param=1,2
        param=>1,<2
        param=1-5 (1 à 5)
        param-not=>1,<3 

    # String

        param=toto (LIKE toto)
        param=*toto* (LIKE %toto%)
        param=*toto,chopi* (LIKE %toto OR LIKE chopi%)
        param-not=*toto (NOT LIKE %toto)

    # Date

        param=2015-01-04 (LIKE 2015-01-04)
        param=2015-01-04* (LIKE 2015-01-04%)
        param=2015-01-04,2015-01-05 (LIKE 2015-01-04 OR LIKE 2015-01-05)
        param=>2015-01-04,<2015-01-08
        param=DAY|01,MONTH|07,YEAR|2015 (DAY(date) = 1, MONTH(date) = etc...)
        param-not=2015-01-04 (NOT LIKE =2015-01-04)

## Relations

    # Belongs to

        relation=1 (relation.primaryKey = 1) (integer)
        relation-prop=10 (relation.prop = 10) (integer/string/date)

    # Has many

        relation=1 (relations.primaryKey.contains 1) (integer)
        relation-prop=lola* (relations.prop.contains lola% ) (integer/string/date)
        relation-count=>45 (45 elements) (integer)

    # Many to Many

        relation=1 (relations.primaryKey.contains 1) (integer)
        relation-prop=lola* (relations.prop.contains lola% ) (integer/string/date)
        relation-pivot-prop=1 (relations.pivot.prop.contains 1) (integer)

## Group

    group=id_utilisateur (GROUP BY id_utilisateur)
        - format de retour : id_utilisateur => {prop: toto, prop: tata}
    group_model=model 
        - format de retour : [ { user: {name: toto, age: 18, models:[query_results] }}]

## Order By

    orderby=field
    orderby=field, field, field
    orderby=COUNT|field,DAY|field,ROUND|field