<?php

    class categories
    {
        private $id;
        private $nom;

        function __construct($id, $nom)
        {
            $this->id = $id;
            $this->nom = $nom;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getNom()
        {
            return $this->nom;
        }

        public function __toString()
        {
            //echo $this->getId();
            //echo $this->getNom();
			return $this->getId(). $this->getNom();
        }
    }
    

    class produits
    {
       private $id;
       private $nom;
       private $prix;
       private $categorie_id;

       function __construct($id, $nom, $prix, $categorie_id)
       {
            $this->id = $id;
            $this->nom = $nom;
            $this->prix = $prix;
            $this->categorie_id = $categorie_id;
       }

       public function getId()
       {
           return $this->id;
       }

       public function getNom()
       {
           return $this->nom;
       }

       public function getPrix()
       {
           return $this->prix;
       }

       public function getCategorieId()
       {
           return $this->categorie_id;
       }

       public function __toString()
       {
           //echo $this->getId();
           //echo $this->getNom();
           //echo $this->getPrix();
           //echo $this->getCategorieId();
		   return $this->getId(). $this->getNom(). $this->getPrix(). $this->getCategorieId();
       }
    }


    class ticket_entry
    {
       private $id;
       private $ticket_id;
       private $produit_id;
       private $quantite;

       function __construct($id, $ticket_id, $produit_id, $quantite)
       {
           $this->id = $id;
           $this->ticket_id = $ticket_id;
           $this->produit_id = $produit_id;
           $this->quantite = $quantite;
       }

       public function getId()
       {
           return $this->id;
       }

       public function getTicketId()
       {
           return $this->ticket_id;
       }

       public function getProduitId()
       {
           return $this->produit_id;
       }

       public function getQuantite()
       {
           return $this->quantite;
       }

       public function __toString()
       {
           //echo $this->getId();
           //echo $this->getTicketId();
           //echo $this->getProduitId();
           //echo $this->getQuantite();
		   return $this->getId(). $this->getTicketId(). $this->getProduitId(). $this->getQuantite();
       }
    }


    class tickets
    {
       private $id;
       private $date;
       private $utilisateur_id;

       function __construct($id, $date, $utilisateur_id)
       {
           $this->id = $id;
           $this->date = $date;
           $this->utilisateur_id = $utilisateur_id;
       }

       public function getId()
       {
           return $this->id;
       }

       public function getDate()
       {
           return $this->date;
       }

       public function getUtilisateurId()
       {
           return $this->utilisateur_id;
       }

       public function __toString()
       {
           //echo $this->getId();
           //echo $this->getDate();
           //echo $this->getUtilisateurId();
		   return $this->getId(). $this->getDate(). $this->getUtilisateurId();
       }
    }


    class utilisateurs
    {
        private $id;
        private $prenom;
        private $nom;

        function __construct($id, $prenom, $nom)
        {
            $this->id = $id;
            $this->prenom = $prenom;
            $this->nom = $nom;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getPrenom()
        {
            return $this->prenom;
        }

        public function getNom()
        {
            return $this->nom;
        }

        public function __toString()
       {
           //echo $this->getId();
           //echo $this->getPrenom();
           //echo $this->getNom();
		   return $this->getId(). $this->getPrenom(). $this->getNom();
       }

    }

?>