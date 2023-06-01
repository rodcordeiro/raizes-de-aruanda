#Dash pontos por ritmo
    SELECT   R.id
           , R.ritmo
           , COUNT(P.id) TOTAL_PONTOS
        FROM icnt_ritmos R
        JOIN icnt_pontos P ON P.ritmo = R.id
    GROUP BY P.ritmo
    ORDER BY TOTAL_PONTOS DESC;
## ---------------------------------- ##
#Dash pontos por linha
	SELECT   L.id
           , L.linha
           , COUNT(P.id) TOTAL_PONTOS
      FROM icnt_linha L
      JOIN icnt_pontos P 
        ON P.linha = L.id
GROUP BY   P.linha DESC
ORDER BY   TOTAL_PONTOS ASC
         , L.linha;
## ---------------------------------- ##
#Dash pontos por categoria
	SELECT   C.id
           , C.categoria
           , COUNT(P.id) TOTAL_PONTOS
      FROM icnt_categoria_linha C
      JOIN icnt_linha L
        ON L.categoria = C.id
      JOIN icnt_pontos P 
        ON P.linha = L.id
GROUP BY   L.categoria DESC
ORDER BY   TOTAL_PONTOS ASC
         , L.linha;
## ---------------------------------- ##
#Dash Total pontos
     SELECT COUNT(P.id) TOTAL_PONTOS
       FROM icnt_pontos P 
   ORDER BY TOTAL_PONTOS ASC
